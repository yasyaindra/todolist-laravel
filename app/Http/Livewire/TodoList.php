<?php

namespace App\Http\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{    
    use WithPagination;
    public $name;
    public $form = false;
    public $single_todo;
    public $single_name;
    public $is_completed = false;

    public function create(){
        $validated = $this->validate([
            "name" => 'required|min:3|max:50'
        ]);

        Todo::create($validated);

        $this->reset('name');

        session()->flash('success','Todo is created!');
    }

    public function delete($id){
        $delete = Todo::findOrFail($id);
        $delete->delete();
        session()->flash('success', "Todo is deleted!");
    }

    public function toggle($id){
        $todo = Todo::find($id);

        $todo->is_completed = !$todo->is_completed;

        $todo->save();

        if($todo->is_completed){
            $message = "Todo is checked";
        } else {
            $message = "Todo is unchecked";
        }


        session()->flash('success', "Todo is " . $message);
    }

    public function edit($id) {
        $this->form = !$this->form;

        $this->single_todo = Todo::find($id)->id;
        $this->single_name = Todo::find($id)->name;
    }

    public function update() {
        Todo::find($this->single_todo)->update([
            'name' => $this->single_name
        ]);

        $this->form = !$this->form;

        session()->flash('success','Todo is updated!');
    }

    public function render()
    {
        return view('livewire.todo-list', ['todos' => Todo::latest()->where("name","like","%{$this->name}%")->paginate(5)]);
    }
}
