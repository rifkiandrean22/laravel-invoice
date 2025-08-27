<?php
namespace App\Enums;
enum OrderStatus: string {
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case RECEIVED = 'received';
}
