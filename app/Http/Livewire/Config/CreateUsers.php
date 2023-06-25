<?php

namespace App\Http\Livewire\Config;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class CreateUsers extends Component
{
    public bool $open = false;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    protected function rules() 
    {
        return [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'min:8','in:'.$this->password_confirmation]
        ];
    }

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)

        ]);

        $this->reset([
            'name',
            'email',
            'password',
            'password_confirmation',
            'open'
        ]);

        $this->emitTo('users','render');
        $this->emit('alert', '¡Usuario: '.$user->name.' registrado con exito!');
    }

    public function render()
    {
        return view('livewire.config.create-users');
    }
}
