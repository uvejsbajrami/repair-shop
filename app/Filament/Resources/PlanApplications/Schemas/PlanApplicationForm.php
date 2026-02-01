<?php

namespace App\Filament\Resources\PlanApplications\Schemas;

use App\Models\ShopPlan;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Utilities\Set;

class PlanApplicationForm
{
 public static function configure(Schema $schema): Schema
 {
  return $schema
   ->components([
    Section::make('Application Details')
     ->schema([
      TextInput::make('user_id')
       ->required()
       ->numeric(),
      TextInput::make('plan_id')
       ->required()
       ->numeric(),
      TextInput::make('shop_name')
       ->required(),
      Select::make('billing_cycle')
       ->options(['monthly' => 'Monthly', 'yearly' => 'Yearly'])
       ->required(),
      TextInput::make('duration_months')
       ->required()
       ->numeric(),
      Select::make('status')
       ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
       ->default('pending')
       ->required(),
      Select::make('type')
       ->options(['new' => 'New Application', 'renewal' => 'Renewal'])
       ->default('new')
       ->disabled(),
     ])
     ->columns(2),

    Section::make('Payment Information')
     ->schema([
      Select::make('payment_status')
       ->options([
        'awaiting_proof' => 'Awaiting Proof',
        'proof_submitted' => 'Proof Submitted',
        'payment_verified' => 'Payment Verified',
        'payment_rejected' => 'Payment Rejected',
       ])
       ->default('awaiting_proof')
       ->live()
       ->afterStateUpdated(function (Set $set, ?string $state) {
        match ($state) {
         'proof_submitted' => $set('status', 'pending'),
         'payment_verified' => $set('status', 'approved'),
         'payment_rejected' => $set('status', 'rejected'),
         default => null,
        };
       })
       ->required(),

      Placeholder::make('payment_proof_preview')
       ->label('Payment Proof')
       ->content(function ($record) {
        if (!$record || !$record->payment_proof_path) {
         return new HtmlString('<span class="text-gray-500">No proof uploaded</span>');
        }

        // Try to find the file
        $possiblePaths = [
         storage_path('app/private/' . $record->payment_proof_path),
         storage_path('app/' . $record->payment_proof_path),
        ];

        $path = null;
        foreach ($possiblePaths as $possiblePath) {
         if (file_exists($possiblePath)) {
          $path = $possiblePath;
          break;
         }
        }

        if (!$path) {
         return new HtmlString('<span class="text-red-500">File not found</span>');
        }

        $imageData = base64_encode(file_get_contents($path));
        $mimeType = mime_content_type($path);
        $fullSizeUrl = route('admin.payment-proof.image', $record->id);

        return new HtmlString(
         '<div>
                  <img src="data:' . $mimeType . ';base64,' . $imageData . '" class="max-w-md max-h-96 rounded-lg shadow border" />
                <p class="text-sm text-gray-500 mt-2">
              <a href="' . $fullSizeUrl . '" target="_blank" class="text-blue-500 hover:underline">Open full size in new tab</a>
           </p>
         </div>'
        );
       })
       ->visible(fn($record) => $record && $record->payment_proof_path),

      Placeholder::make('payment_proof_uploaded_at_display')
       ->label('Proof Uploaded')
       ->content(fn($record) => $record?->payment_proof_uploaded_at?->format('M d, Y H:i') ?? 'Not uploaded'),

      Textarea::make('payment_notes')
       ->label('Admin Notes')
       ->rows(3)
       ->placeholder('Add notes about payment verification...'),
     ])
     ->columns(1),
   ]);
 }
}
