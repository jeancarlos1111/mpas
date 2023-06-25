<?php

namespace App\Http\Livewire\Category;
use Livewire\WithPagination;

use Livewire\Component;
use App\Models\Category;

class Categories extends Component
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
    public $category;

    protected $listeners = ['render', 'deleteCategory' => 'delete'];

    protected $queryString = ['search' => ['except' => ''], 'direction' => ['except' => 'asc'], 'cant' => ['except' => 10]];

    protected function rules() 
    {
        return [
            'category.name' => 'required|min:4',
            'category.slug' => 'required|min:4',
        ];
    }
    /* Carga diferida de los datos */
    public function loadCategories()
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
            $categories = Category::where('name', 'LIKE', '%'. $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        } else {
            $categories = [];
        }
        return view('livewire.category.index', compact('categories'));
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

    public function edit(Category $category, $name) 
    {
        $this->open_edit = true;
        $this->old_name = $name;
        $this->category = $category;
    }

    public function update()
    {
        $this->validate();

        $this->category->save();

        $this->reset([
            'open_edit',
            'old_name',
        ]);
    
        $this->emitTo('users','render');
        $this->emit('alert', '¡Categoria: '.$this->category->name.' actualizado con exito!');
    }

    public function delete(Category $category) {
        $category->delete();
    }
}
