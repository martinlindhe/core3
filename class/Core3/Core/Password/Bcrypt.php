<?php
namespace Core3\Core\Password;

/**
 * NOTE: password_hash() is available since PHP 5.5.0,
 *       we use password-compat to support PHP 5.3.7+
 */
class Bcrypt extends \Core3\Core\Password
{
    protected $cost;

    public function __construct($cost = 10)
    {
        $this->cost = $cost;
    }

    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Creates a hash of input text
	 * @return 60-byte string with password hash
	 */
    public function hash($s)
    {
        $options = array(
        'cost' => $this->cost,
        );

        return password_hash($s, PASSWORD_BCRYPT, $options);
    }

    /**
	 * Determines if password hash needs to be re-generated when cost has changed
	 * @param $hash current hash
	 * @param $new_cost new cost
	 * @return bool
	 */
    public function needsRehash($hash, $newCost)
    {
        $options = array(
        'cost' => $newCost,
        );

        return password_needs_rehash($hash, PASSWORD_BCRYPT, $options);
    }

    /**
	 * Verifies if entered string matches a stored hash
	 * @return bool
	 */
    public function verify($s, $hash)
    {
        return password_verify($s, $hash);
    }
}
