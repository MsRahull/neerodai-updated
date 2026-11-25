<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Contact;
use App\Models\Donation;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        $now = CarbonImmutable::now();
        $paid = fn () => Donation::where('status', 'success');

        $thisMonthStart = $now->startOfMonth();
        $lastMonthStart = $now->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd   = $lastMonthStart->endOfMonth();

        $thisMonthTotal = (float) $paid()->where('created_at', '>=', $thisMonthStart)->sum('amount');
        $lastMonthTotal = (float) $paid()->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('amount');

        $stats = [
            'contacts'         => Contact::count(),
            'contacts_month'   => Contact::where('created_at', '>=', $thisMonthStart)->count(),
            'payments'         => $paid()->count(),
            'payments_total'   => (float) $paid()->sum('amount'),
            'last_month_count' => $paid()->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count(),
            'last_month_total' => $lastMonthTotal,
            'month_change'     => $lastMonthTotal > 0
                ? round((($thisMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100)
                : null,
            'blogs'            => Blog::count(),
        ];

        $chartData = [
            'year'  => $this->monthly($now->startOfYear(), $now->endOfYear(), 'Per Month Payment ' . $now->year),
            'month' => $this->weekly($thisMonthStart, $now->endOfMonth()),
            'six'   => $this->monthly($now->subMonthsNoOverflow(5)->startOfMonth(), $now->endOfMonth(), 'Last 6 Months'),
            'last'  => $this->monthly($now->subYear()->startOfYear(), $now->subYear()->endOfYear(), 'Last Year (' . ($now->year - 1) . ')'),
        ];

        $recent = Donation::latest()->take(5)->get();

        return view('admin.main', compact('stats', 'chartData', 'recent'));
    }

    /** Sum of successful donations per month between two dates. */
    private function monthly(CarbonImmutable $from, CarbonImmutable $to, string $label): array
    {
        $sums = Donation::where('status', 'success')
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, SUM(amount) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $labels = $data = [];
        foreach (CarbonPeriod::create($from->startOfMonth(), '1 month', $to) as $month) {
            $labels[] = $month->format('M');
            $data[]   = (float) ($sums[$month->format('Y-m')] ?? 0);
        }

        return compact('label', 'labels', 'data');
    }

    /** Sum of successful donations per week (1st–7th, 8th–14th, …) of the month. */
    private function weekly(CarbonImmutable $from, CarbonImmutable $to): array
    {
        $rows = Donation::where('status', 'success')
            ->whereBetween('created_at', [$from, $to])
            ->get(['amount', 'created_at']);

        $weeks = (int) ceil($to->day / 7);
        $data  = array_fill(0, $weeks, 0.0);
        foreach ($rows as $row) {
            $data[intdiv($row->created_at->day - 1, 7)] += (float) $row->amount;
        }

        $labels = array_map(fn ($i) => 'Week ' . ($i + 1), array_keys($data));

        return ['label' => 'This Month', 'labels' => $labels, 'data' => $data];
    }
}
