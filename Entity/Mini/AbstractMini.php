<?php
/**
 * Description of AbstractMini
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Entity\Mini;

use Box\Entity\AbstractEntity;

abstract class AbstractMini extends AbstractEntity
{
    /**
     * The time this user was last modified
     *
     * @var \DateTime
     */
    protected $modifiedAt;
    

    static protected function _convertToTarget($data)
    {
        if ($user instanceof User) {
            return $user;

        } else if ($user === null) {
            return null;

        } else if (is_string($user) && $user{0} === '{') {
            // JSON string
            if (false === ($obj = json_decode($user, true))) {
                throw new Exception('Object "'.$user.'" couldn\'t be converted to Mimi\\User object');
            }

            $user = $obj;
        } else if (!is_array($user)) {
            throw new Exception("Unknown object for convertation to User");
        }

        $miniUser = new self();

        foreach ($user as $field => $value) {
            $setter = 'set' . str_replace('_', '', ucfirst($field));
            if (!method_exists($miniUser, $setter)) {
                throw new Exception('Unknown method name "'.$setter.'" in Box\\Entity\\Mini\\User');
            }

            $miniUser->$setter($value);
        }

        return $miniUser;
    }
}
