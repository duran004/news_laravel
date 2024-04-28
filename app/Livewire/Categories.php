<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Validate;

class Categories extends Component
{
    #[Validate('required|string|max:255|min:3')]
    public $search;
    public $categories;

    public function mount()
    {
        $this->categories = Category::all();
    }
    public function updatedSearch()
    {
        $this->validate();
        $categories = Category::where('name', 'like', '%' . $this->search . '%')->get();
        if ($categories->count() == 0) {
            session()->flash('error', 'No results found');
        }
        $this->categories = $categories;
    }
    public function delete($id)
    {
        Category::destroy($id);
        $this->categories = Category::all();
    }
    public function render()
    {
        return view('livewire.categories', [
            'categories' => $this->categories
        ]);
    }
}
