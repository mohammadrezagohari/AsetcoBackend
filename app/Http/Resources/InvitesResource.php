<?php

namespace App\Http\Resources;

use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/*************
 * @mixin Invite
 */
class InvitesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'inviter_by_name' => $this->User->name,
            'invited_mobile_number'=>$this->invited_mobile_number,
            'accepted'=>$this->accepted
        ];

    }
}
