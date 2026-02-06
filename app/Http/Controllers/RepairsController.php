<?php

namespace App\Http\Controllers;

use App\Models\RepairLog;
use App\Models\Shop;
use App\Models\Repair;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RepairsController extends Controller
{
    public function ownerRepairs()
    {
        $shopid = Shop::where('owner_id', auth()->id())->value('id');

        $pending = Repair::where('shop_id', $shopid)
            ->where('status', 'pending')
            ->get();

        $working = Repair::where('shop_id', $shopid)
            ->where('status', 'working')
            ->get();

        $finished = Repair::where('shop_id', $shopid)
            ->where('status', 'finished')
            ->get();

        return view('owner.repairs', [
            'pending' => $pending,
            'working' => $working,
            'finished' => $finished,
        ]);
    }
    public function repairsLogs()
    {
        $shopid = Shop::where('owner_id', auth()->id())->value('id');

        $repairsLogs = RepairLog::whereHas('repair', function ($query) use ($shopid) {
            $query->where('shop_id', $shopid);
        })
        ->where('new_status', 'pickedup')
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('owner.repairslog', [
            'repairsLogs' => $repairsLogs,
        ]);
    }

    public function RepairsAll()
    {
        $shopid = Shop::where('owner_id', auth()->id())->value('id');

        $repairs = Repair::where('shop_id', $shopid)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('owner.exportfile', [
            'repairs' => $repairs,
        ]);
    }

    public function exportRepairs(Request $request)
    {
        $shopid = Shop::where('owner_id', auth()->id())->value('id');

        // Check if specific IDs are provided (selected exports)
        if ($request->has('ids') && !empty($request->ids)) {
            $ids = explode(',', $request->ids);
            $repairs = Repair::where('shop_id', $shopid)
                ->whereIn('id', $ids)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Export all repairs
            $repairs = Repair::where('shop_id', $shopid)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $filename = 'repairs_export_' . date('Y-m-d_H-i-s') . '.csv';

        $response = new StreamedResponse(function () use ($repairs) {
            $handle = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Header
            fputcsv($handle, [
                'ID',
                'Tracking Code',
                'Customer Name',
                'Customer Phone',
                'Device Type',
                'Issue Description',
                'Notes',
                'Status',
                'Price',
                'Created At',
                'Updated At'
            ]);

            // CSV Data
            foreach ($repairs as $repair) {
                fputcsv($handle, [
                    $repair->id,
                    $repair->tracking_code,
                    $repair->customer_name,
                    $repair->customer_phone,
                    $repair->device_type,
                    $repair->issue_description,
                    $repair->notes,
                    $repair->status,
                    $repair->price_amount . (trackingshop($repair->shop_id)?->currency_symbol ?? '€'),
                    $repair->created_at->format('d/m/Y H:i'),
                    $repair->updated_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
