<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'primary_color',
        'secondary_color',
        'accent_color',
        'menu_bg',
        'footer_bg',
        'section_bg',
        // Extended theme variables
        'primary_dark',
        'light',
        'border',
        'text_muted',
        'success_bg',
        'success_text',
        'info_bg',
        'info_text',
        'warning_bg',
        'warning_text',
        'danger_bg',
        'danger_text',
        'secondary_bg',
        'secondary_text',
        'start_date',
        'end_date',
        'is_active',
        'is_scheduled',
        // Ribbon controls
        'ribbon_enabled',
        'ribbon_variant',
        'ribbon_primary',
        'ribbon_base',
        'ribbon_stroke',
        'mourning_enabled',
        'ribbon_label',
        'ribbon_link_url',
        'ribbon_link_external',
        // Campos específicos por lacinho
        'ribbon_campaign_label',
        'ribbon_campaign_link_url',
        'ribbon_campaign_link_external',
        'ribbon_mourning_label',
        'ribbon_mourning_link_url',
        'ribbon_mourning_link_external',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_scheduled' => 'boolean',
        'ribbon_enabled' => 'boolean',
        'mourning_enabled' => 'boolean',
        'ribbon_link_external' => 'boolean',
        'ribbon_campaign_link_external' => 'boolean',
        'ribbon_mourning_link_external' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Escopo para recuperar temas efetivamente ativos:
     * - is_active = true OU
     * - is_scheduled = true E hoje dentro do intervalo [start_date, end_date]
     */
    public function scopeEffectiveActive($query)
    {
        $today = now()->toDateString();
        return $query->where(function ($q) use ($today) {
            $q->where('is_active', true)
              ->orWhere(function ($q2) use ($today) {
                  $q2->where('is_scheduled', true)
                     ->whereDate('start_date', '<=', $today)
                     ->whereDate('end_date', '>=', $today);
              });
        });
    }

    /**
     * Atributo calculado para indicar se o tema está ativo no momento
     * considerando agendamento vigente.
     */
    public function getIsCurrentlyActiveAttribute(): bool
    {
        if ($this->is_active) {
            return true;
        }
        if ($this->is_scheduled && $this->start_date && $this->end_date) {
            $today = now()->toDateString();
            return $this->start_date->toDateString() <= $today && $this->end_date->toDateString() >= $today;
        }
        return false;
    }
}