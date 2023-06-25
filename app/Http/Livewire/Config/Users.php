<?php

namespace App\Http\Livewire\Config;
use Livewire\WithPagination;

use Livewire\Component;
use App\Models\User;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $sort = 'id';
    public $direction = 'asc';
    public $cant = 5;
    public $readyToLoad = false;
    //para editar
    public $open_edit = false;
    public $old_name;
    public $user;

    protected $listeners = ['render', 'deleteUser' => 'delete'];

    protected $queryString = ['search' => ['except' => ''], 'direction' => ['except' => 'asc'], 'cant' => ['except' => 10]];

    protected function rules() 
    {
        return [
            'user.name' => 'required|min:4',
            'user.email' => 'required|email|unique:users,email,'.$this->user->id,
        ];
    }
    /* Carga diferida de los datos */
    public function loadUsers()
    {
        $this->readyToLoad = true;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if($this->readyToLoad) {
            $users = User::where('name', 'LIKE', '%'. $this->search . '%')
            ->orWhere('email', 'LIKE', '%'. $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        } else {
            $users = [];
        }
        return view('livewire.config.users', compact('users'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
            
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
        //
    }

    public function edit(User $user, $name) 
    {
        $this->open_edit = true;
        $this->old_name = $name;
        /* $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email; */
        $this->user = $user;
    }

    public function update()
    {
        $this->validate();

        $this->user->save();

        $this->reset([
            'open_edit',
            'old_name',
        ]);
    
        $this->emitTo('users','render');
        $this->emit('alert', '¡Usuario: '.$this->user->name.' actualizado con exito!');
    }

    public function delete(User $user) {
        $user->delete();
    }
}
