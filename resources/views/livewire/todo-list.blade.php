<div>
    <div class="container mt-5">
        <h1 class="text-center mb-4">To Do List App</h1>
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <form>
                <div class="input-group mb-3">
                    <input
                        type="text" wire:model.live.debounce.500ms="name"
                        class="form-control"
                    />
                    <button wire:click.prevent="create" type="submit" class="btn btn-dark">
                        Add
                    </button>
                </div>
            </form>

            @if (session('success'))
            <div
              class="alert alert-success alert-dismissible fade show"
              role="alert"
            >
            {{session('success')}}
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
              ></button>
            </div>
            @endif

            @error('name')
            <div
              class="alert alert-danger alert-dismissible fade show"
              role="alert"
            >
            {{$message}}
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
              ></button>
            </div>
            @enderror
            @foreach ($todos as $todo)
            <div class="row justify-content-between align-items-center mb-3 mt-4" wire:key="{{$todo->id}}">
              <div class="col-1 col-sm-1 col-lg-1">
                <div class="input-group mb-3">
                    <input class="form-check-input mt-0" wire:click="toggle({{$todo->id}})" type="checkbox" {{$todo->is_completed ? 'checked' : ''}}>
                </div>                
              </div>
              @if ($form && $todo->id === $single_todo)
                <div class="col col-sm col-lg">
                  <div class="mb-3">
                    <input type="text" class="form-control" wire:model="single_name">
                  </div>
                  <div class="row gap-2">
                    <div class="col-lg-1">
                      <button class="btn btn-success" wire:click="update">
                        <i class="fa-solid fa-check"></i>
                      </button>
                    </div>
                    <div class="col-lg-1">
                      <button class="btn btn-danger" wire:click='edit({{$todo->id}})'>
                        <i class="fa-solid fa-x"></i>
                      </button>
                    </div>  
                  </div>              
                </div>
              @else
              <div class="col col-sm col-lg">
                <h3 class="{{$todo->is_completed ? 'text-decoration-line-through' : ''}}">{{$todo->name}}</h3>
                <span class="text-gray fw-light fs-7 {{$todo->is_completed ? 'text-decoration-line-through' : ''}}">{{$todo->created_at->diffForHumans()}}</span>
              </div>
              @endif
              <div class="col-3 col-sm-3 col-lg-2">
                <button class="btn btn-light text-success" wire:click="edit({{$todo->id}})">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button wire:click="delete({{$todo->id}})" class="btn btn-light text-danger">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>
            </div>
            @endforeach
            <div class="my-2">
              {{$todos->links('pagination::bootstrap-5')}}
            </div>
          </div>
        </div>
      </div>  
</div>
