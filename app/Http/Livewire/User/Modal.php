<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open;
    public $userId;
    public $name;
    public $email;
    public $role;

    protected $listeners = ['abrirModal'];

    protected function rules(){
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->userId,
            'role' => 'required',
        ];
    }

    public function messages(){
        return [
            'name.required' => "El nombre es requerido",
            'email.unique' => "El correo electrónico ya existe",
            'email.required' => "El correo electrónico es requerido",
            'role.required' => "El rol es requerido",
        ];
    }

    public function mount(){
        $this->open = false;
        $this->name = "";
        $this->email = "";
        $this->role = "Colaborador";
    }

    public function abrirModal($id){
        $this->resetValidation();
        $this->reset('name','email');
        $this->role = 2;
        $this->userId = $id;
        if($id > 0){
            $user = User::find($id);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->roles[0]->name == "administrador" ? 1 : 2;
        }
        $this->open = true;
    }

    public function registrar(){
        $this->validate();
        if($this->userId > 0){
            $user = User::find($this->userId);

        }else{
            $user = new User();
            $user->email_verified_at = now();
            $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
            $user->remember_token = Str::random(10);
        }
        $user->name = $this->name;
        $user->email = $this->email;
        if($this->userId != Auth::user()->id){
            $role = $this->role == 1 ? 'administrador' : 'colaborador';
            $user->syncRoles([$role]);
        }

        $user->save();
        $this->alert('success', 'Usuario guardado!', [
            'position' => 'top-right',
            'timer' => 2000,
            'toast' => true,
           ]);
        $this->emitTo('user.base', 'render');
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.user.modal');
    }
}
