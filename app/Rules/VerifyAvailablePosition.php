<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Member;

class VerifyAvailablePosition implements Rule
{
    public $placementUser;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($placementUser)
    {
        $this->placementUser = $placementUser;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $member = Member::select('id')->where('username', $this->placementUser)->first();
        if($member) {
            $available = Member::select('id')->where(['placement_id' => $member->id, 'position' => $value])->first();
            if(!$available) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
