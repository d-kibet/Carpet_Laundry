<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Expense extends Model implements HasMedia
{
    use HasFactory, Auditable, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('expense_date', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('expense_date', now()->month)
                    ->whereYear('expense_date', now()->year);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'Approved');
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', 'Pending');
    }

    public function getFormattedAmountAttribute()
    {
        return 'KES ' . number_format($this->amount, 2);
    }

    public function requiresApproval()
    {
        return $this->category && $this->category->requires_approval;
    }

    protected function getAuditTags(): array
    {
        return [
            'module' => 'expense',
            'category' => $this->category->name ?? null,
            'amount' => $this->amount ?? null,
            'vendor' => $this->vendor_name ?? null,
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('receipts')
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('receipts');

        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('receipts');
    }

    public function getReceiptUrlAttribute()
    {
        $media = $this->getFirstMedia('receipts');
        return $media ? $media->getUrl() : null;
    }

    public function getReceiptPreviewUrlAttribute()
    {
        $media = $this->getFirstMedia('receipts');
        return $media ? $media->getUrl('preview') : null;
    }

    public function getReceiptThumbUrlAttribute()
    {
        $media = $this->getFirstMedia('receipts');
        return $media ? $media->getUrl('thumb') : null;
    }

    public function hasValidReceipt()
    {
        return $this->hasMedia('receipts');
    }

    // Legacy support for old receipt_image column (will be removed after migration)
    public function getReceiptImageAttribute()
    {
        $media = $this->getFirstMedia('receipts');
        return $media ? $media->file_name : null;
    }
}