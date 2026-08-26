<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ProductionBundle extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'bundle_no', 'buyer_id', 'style_id', 'color', 'size',
        'line_id', 'quantity', 'completed_qty', 'rejected_qty',
        'operator_name', 'production_date', 'remarks',
    ];

    protected $casts = [
        'production_date' => 'date',
        'quantity'        => 'integer',
        'completed_qty'   => 'integer',
        'rejected_qty'    => 'integer',
    ];

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                        */
    /* ------------------------------------------------------------------ */

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
    }

    public function sewingLine(): BelongsTo
    {
        return $this->belongsTo(SewingLine::class, 'line_id');
    }

    /* ------------------------------------------------------------------ */
    /*  Computed Accessors                                                   */
    /* ------------------------------------------------------------------ */

    public function getBalanceQtyAttribute(): int
    {
        return max(0, $this->quantity - $this->completed_qty - $this->rejected_qty);
    }

    public function getEfficiencyPctAttribute(): float
    {
        if ($this->quantity <= 0) return 0.0;
        return round(($this->completed_qty / $this->quantity) * 100, 2);
    }

    public function getRejectionPctAttribute(): float
    {
        if ($this->quantity <= 0) return 0.0;
        return round(($this->rejected_qty / $this->quantity) * 100, 2);
    }

    /* ------------------------------------------------------------------ */
    /*  Activity Log Config                                                  */
    /* ------------------------------------------------------------------ */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $event) => "Bundle {$this->bundle_no} was {$event}");
    }

    /* ------------------------------------------------------------------ */
    /*  Scopes for Search / Filter                                           */
    /* ------------------------------------------------------------------ */

    public function scopeSearch($query, ?string $term)
    {
        if (!$term) return $query;
        return $query->where(function ($q) use ($term) {
            $q->where('bundle_no', 'like', "%{$term}%")
              ->orWhere('operator_name', 'like', "%{$term}%")
              ->orWhere('color', 'like', "%{$term}%")
              ->orWhereHas('buyer', fn($b) => $b->where('buyer_name', 'like', "%{$term}%"))
              ->orWhereHas('style', fn($s) => $s->where('style_no', 'like', "%{$term}%"));
        });
    }

    public function scopeFilterBuyer($query, ?int $buyerId)
    {
        return $buyerId ? $query->where('buyer_id', $buyerId) : $query;
    }

    public function scopeFilterStyle($query, ?int $styleId)
    {
        return $styleId ? $query->where('style_id', $styleId) : $query;
    }

    public function scopeFilterLine($query, ?int $lineId)
    {
        return $lineId ? $query->where('line_id', $lineId) : $query;
    }

    public function scopeFilterDateRange($query, ?string $from, ?string $to)
    {
        if ($from) $query->whereDate('production_date', '>=', $from);
        if ($to)   $query->whereDate('production_date', '<=', $to);
        return $query;
    }
}
