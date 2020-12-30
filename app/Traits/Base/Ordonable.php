<?php


namespace App\Traits\Base;

use Illuminate\Support\Facades\DB;

trait Ordonable
{
    /**
     * Retourne le nom de la table du modèle qui implémente le Trait
     * @return string
     */
    abstract protected function tableName(): string;

    public function reorder($pivot_col, $pivot_val, $oldOrd, $newOrd) {
        if ( ($newOrd - $oldOrd) < 0) {
            DB::table($this->tableName())
                ->where($pivot_col, $pivot_val)
                ->where('ord', '>=', $newOrd)
                ->where('ord', '<=', $oldOrd)
                ->increment('ord', 1);
        } else {
            DB::table($this->tableName())
                ->where($pivot_col, $pivot_val)
                ->where('ord', '>=', $oldOrd)
                ->where('ord', '<=', $newOrd)
                ->decrement('ord', 1);
        }
        $this->update([
            'ord' => $newOrd,
        ]);
    }
}
