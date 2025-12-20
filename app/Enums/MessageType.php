<?php


namespace App\Enums;
enum MessageType: string
{
    case CREATED = 'Berhasil ditambahkan';
    case UPDATED = 'Berhasil diperbarui';
    case DELETED = 'Berhasil dihapus';
    case ERROR = 'Terjadi kesalahan. Coba lagi nanti';

    public function message(string $entity = '',? string $error = null): string
    {
        if ($this === MessageType::ERROR && $error) {
            return "{$this->value} {$error}";
        }
        return "{$this->value} {$entity}";
    }
}