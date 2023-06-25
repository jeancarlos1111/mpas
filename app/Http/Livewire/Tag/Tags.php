<?php

namespace App\Http\Livewire\Tag;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Tag;

class Tags extends Component
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
    public $tag;

    protected $listeners = ['render', 'deleteTag' => 'delete'];

    protected $queryString = ['search' => ['except' => ''], 'direction' => ['except' => 'asc'], 'cant' => ['except' => 10]];

    protected function rules() 
    {
        return [
            'tag.name' => 'required|min:4',
            'tag.slug' => 'required|min:4',
        ];
    }
    /* Carga diferida de los datos */
    public function loadTags()
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
            $tags = Tag::where('name', 'LIKE', '%'. $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        } else {
            $tags = [];
        }
        return view('livewire.tag.tags', compact('tags'));
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

    public function edit(Tag $tag, $name) 
    {
        $this->open_edit = true;
        $this->old_name = $name;
        $this->tag = $tag;
    }

    public function update()
    {
        $this->validate();

        $this->tag->save();

        $this->reset([
            'open_edit',
            'old_name',
        ]);
    
        $this->emitTo('users','render');
        $this->emit('alert', '¡Etiqueta: '.$this->tag->name.' actualizado con exito!');
    }

    public function delete(Tag $tag) {
        $tag->delete();
    }
}
