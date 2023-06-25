<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;

class CreateCategories extends Component
{
    public bool $open = false;
    public $name;
    public $slug;
    protected function rules() 
    {
        return [
            'name' => 'required|min:4',
            'slug' => 'required',
        ];
    }

    public function save()
    {
        $this->validate();

        $category = Category::create([
            'name' => $this->name,
            'slug' => $this->slug,

        ]);

        $this->reset([
            'name',
            'slug',
            'open'
        ]);

        $this->emitTo('category.categories','render');
        $this->emit('alert', '¡Categoria: '.$category->name.' registrado con exito!');
    }

    public function render()
    {
        return view('livewire.category.create-categories');
    }
}
