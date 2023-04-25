<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $userId;
    public $search;
    public $boton_activo;

    protected $listeners = ['render','confirmDelete'];

    public function mount(){
        $this->userId = 0;
        $this->search = "";
        $this->boton_activo = false;
    }

    public function seleccionar($id) {
        $this->userId = $id;
    }

    public function getUsers(){
        $users = User::when($this->search != "", function($q){
            return $q->where('name','like','%'.$this->search.'%')->orWhere('email','like','%'.$this->search.'%');
        })->paginate(6);
        return $users;
    }

    public function render()
    {
        $this->boton_activo = $this->userId > 0;
        $users = $this->getUsers();
        return view('livewire.user.base',compact('users'));
    }
}
