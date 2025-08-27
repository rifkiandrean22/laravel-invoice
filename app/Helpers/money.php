<?php
if (! function_exists('rupiah')) {
    function rupiah(int|float|null $value): string {
        $value = $value ?? 0;
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}
