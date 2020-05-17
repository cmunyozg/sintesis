<?php
// src/Form/Model/ChangePassword.php
namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswd
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Error al poner la contraseña actual."
     * )
     */
    protected $old;

    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "El password tiene que tener al menos 6 caracteres."
     * )
     */
    protected $new;

    public function getOld()
    {
        return $this->old;
    }

    public function setOld($old)
    {
        $this->old = $old;
        return $this;
    }


    public function getNew()
    {
        return $this->new;
    }

    public function setNew($new){
        $this->new = $new;
        return $this;
    }


}
