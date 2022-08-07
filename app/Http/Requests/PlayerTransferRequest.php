<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PlayerTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $player = null;

        if($this->has('player_id')){
            $player = Player::find($this->player_id);
        }
//dd([
//    'player_id' => 'required|exists:players,id',
//    'team_to' => 'required|exists:teams,id|' . ($player ? "|not_in:$player->team_id" : ""),
//]);
        return [
            'player_id' => 'required|exists:players,id',
            'team_to' => 'required|exists:teams,id' . ($player ? "|not_in:$player->team_id" : ""),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        response()->json($validator->errors(), 422)->throwResponse();
    }
}
