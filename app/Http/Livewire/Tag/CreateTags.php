<?php

namespace App\Http\Livewire\Tag;

use Livewire\Component;
use App\Models\Tag;

class CreateTags extends Component
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

        $tag = Tag::create([
            'name' => $this->name,
            'slug' => $this->slug,

        ]);

        $this->reset([
            'name',
            'slug',
            'open'
        ]);

        $this->emitTo('tag.tags','render');
        $this->emit('alert', '¡Etiqueta: '.$tag->name.' registrado con exito!');
    }

    public function render()
    {
        return view('livewire.tag.create-tags');
    }
}
