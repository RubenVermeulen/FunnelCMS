<?php

namespace FunnelCms\Validation;

use FunnelCms\Translator\Translator;
use Violin\Violin;
use FunnelCms\User\User;
use FunnelCms\Helpers\Hash;

class Validator extends  Violin
{
    /**
     * User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * Hash instance.
     *
     * @var Hash
     */
    protected $hash;

    /**
     * Possible user instance of the authenticated user.
     *
     * @var null
     */
    protected $auth;

    /**
     * Initiate the Validator instance.
     *
     * @param User $user
     * @param Hash $hash
     * @param null $auth
     * @param Translator $translator
     */
    public function __construct(User $user, Hash $hash, $auth = null, Translator $translator) {
        $this->user = $user;
        $this->hash = $hash;
        $this->auth = $auth;
        $this->translator = $translator;

        $this->addFieldMessages([
            'email' => [
                'uniqueEmail' => 'Het e-mailadres is al gebruikt.'
            ],
            'username' => [
                'uniqueUsername' => 'De gebruikersnaam is al gebruikt.'
            ],
            'password_confirm' => [
                'matches' => '{field} moet overeenkomen met wachtwoord.'
            ]
        ]);

        $this->addRuleMessages([
            'required' => $translator->get('ValidationRequired'),
            'int' => $translator->get('ValidationInt'),
            'min' => $translator->get('ValidationMin'),
            'max' => $translator->get('ValidationMax'),
            'between' => $translator->get('ValidationBetween'),
            'alnumDash' => $translator->get('ValidationAlnumDash'),
            'email' => $translator->get('ValidationEmail'),
            'matchesCurrentPassword' =>$translator->get('ValidationMatchesCurrentPassword'),
        ]);
    }

    /**
     * Checks if the email is unique.
     *
     * @param $value
     * @param $input
     * @param $args
     * @return bool
     */
    public function validate_uniqueEmail($value, $input, $args) {
        $user = $this->user->withTrashed()->where('email', $value);

        /*
         * Exclude email address.
         */
        if ( ! empty($args)) {

            $user->where('email', '!=', $args[0]);
        }

        return ! (bool) $user->count();
    }

    /**
     * Checks if the username is unique.
     *
     * @param $value
     * @param $input
     * @param $args
     * @return bool
     */
    public function validate_uniqueUsername($value, $input, $args) {
        $user = $this->user->withTrashed()->where('username', $value);

        return ! (bool) $user->count();
    }

    /**
     * Checks if the current password matches the given one.
     *
     * @param $value
     * @param $input
     * @param $args
     * @return bool
     */
    public function validate_matchesCurrentPassword($value, $input, $args) {
        if ($this->auth && $this->hash->passwordCheck($value, $this->auth->password)) {
            return true;
        }

        return false;
    }

    public function validate_resultFormat($value, $input, $args) {
        if (empty($value)) {
            return true;
        }

        $pattern = '/^\d{1,2}\s\d{1,2}$/';

        if (preg_match($pattern, $value)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the membership id is unique.
     *
     * @param $value
     * @param $input
     * @param $args
     * @return bool
     */
    public function validate_uniqueMembershipId($value, $input, $args) {
        $player = $this->player->where('membership_id', $value);

        return ! (bool) $player->count();
    }
}