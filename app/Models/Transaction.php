<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $basket_id
 * @property float $amount
 * @property string $subject
 * @property string $AccessToken
 * @property string $invoiceID
 * @property string $status
 * @property string $CellNumber
 * @property string $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction whereAccessToken($value)
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereBasketId($value)
 * @method static Builder|Transaction whereCellNumber($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereInvoiceID($value)
 * @method static Builder|Transaction wherePayload($value)
 * @method static Builder|Transaction whereStatus($value)
 * @method static Builder|Transaction whereSubject($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $bank
 * @property string|null $trace_number
 * @property string|null $document_number
 * @property string|null $digital_receipt
 * @property string|null $is_suer_bank
 * @property string|null $card_number
 * @property string|null $access_token
 * @property-read \App\Models\Basket $Basket
 * @method static Builder|Transaction whereBank($value)
 * @method static Builder|Transaction whereCardNumber($value)
 * @method static Builder|Transaction whereDigitalReceipt($value)
 * @method static Builder|Transaction whereDocumentNumber($value)
 * @method static Builder|Transaction whereIsSuerBank($value)
 * @method static Builder|Transaction whereTraceNumber($value)
 */
class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*********************
     * @return BelongsTo
     */
    public function Basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class);
    }

}
