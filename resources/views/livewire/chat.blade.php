<div wire:poll>

    <section style="background-color: #eee;">
        <div class="container py-7se ">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-lg-8 col-xl-10">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center p-3" style="border-top: 4px solid #ffa900;">
                            <h5 class="mb-0">Chat messages</h5>
                            <div class="d-flex flex-row align-items-center">
                                <span class="badge bg-warning me-3">{{ date('F j, Y') }}</span>
                            </div>
                        </div>
                        @if ($messages->isEmpty())
                            <h5 style="text-align: center; color: red;">لا توجد رسائل سابقة</h5>
                        @else
                            <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; max-height: 400px; overflow-y: auto;">
                                @foreach ($messages as $message)
                                    @if ($message->user->id !== auth()->user()->id)
                                        <div class="d-flex flex-column mb-3 align-items-start">
                                            <div class="d-flex flex-row justify-content-start">
                                                <img src="{{ URL::asset('photos/' . $message->user->photo) }}" alt="User Photo" style="width: 40px; height: 40px; border-radius: 50%;">
                                                <div class="ml-2">
                                                    <p class="small mb-0 text-muted mr-3"> &nbsp;&nbsp;{{ $message->user->name}}</p>
                                                    <p class="small p-2 ms-3 mb-0 rounded-3" style="background-color: #f5f6f7; border-radius: 50px; padding: 5px 10px; word-break: break-all;">
                                                        @if($message->message_text)
                                                            {{ $message->message_text }}
                                                            <span>
                                                                <a wire:click="deleteId({{ $message->id }}, '{{$message->file}}')" class="delete-message-btn" title="Delete Message">
                                                                    <span style="display: inline-block; cursor: pointer; color: black;" onmouseover="this.style.color='red'" onmouseout="this.style.color='black'">
                                                                        &#10005;
                                                                    </span>
                                                                </a>
                                                            </span>
                                                        @endif
                                                        @if ($message->file)
                                                            @if (Str::contains($message->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                                                <img src="{{ asset('storage/' . $message->file) }}" alt="Message Attachment" class="img-thumbnail" style="width: 200px; height: 200px;">
                                                            @elseif (Str::contains($message->file, ['.pdf']))
                                                                <iframe src="{{ asset('storage/' . $message->file) }}" style="width: 200px; height: 200px;"></iframe>
                                                            @endif
                                                            <br>
                                                            <span>
                                                                <a wire:click="downloadFile({{ $message->id }}, '{{$message->file}}')" class="delete-message-btn" title="Download File">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                                    </svg>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </span>
                                                            <span>
                                                                 @if (!$message->message_text || !Str::contains($message->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                                                    @if (Str::contains($message->file, ['.pdf']))
                                                                    @else
                                                                        <a wire:click="viewFile({{ $message->id }}, '{{$message->file}}')" class="delete-message-btn" title="View File">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                                            </svg>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            </span>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <span>
                                                                <a wire:click="deleteId({{ $message->id }}, '{{$message->file}}')" class="delete-message-btn" title="Delete Message">
                                                                    &#10005;
                                                                </a>
                                                            </span>
                                                        @endif
                                                    </p>

                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start">
                                                <p class="small mb-0 text-muted ml-3">{{ $message->created_at->diffForHumans(null, false, false)}}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex flex-column mb-3 align-items-end">
                                            <div class="d-flex flex-row justify-content-end">
                                                <div class="mr-2">

                                                    <p class="small p-2 me-3 mb-0 text-white rounded-3 bg-warning" style="border-radius: 150px; padding: 5px 10px; word-break: break-all;">
                                                        @if($message->message_text)
                                                        {{ $message->message_text }}
                                                            <span>
                                                                <a wire:click="deleteId({{ $message->id }}, '{{$message->file}}')" class="delete-message-btn" title="Delete Message">
                                                                    <span style="display: inline-block; cursor: pointer; color: black;" onmouseover="this.style.color='red'" onmouseout="this.style.color='black'">
                                                                        &#10005;
                                                                    </span>
                                                                </a>
                                                            </span>
                                                        @endif
                                                        @if ($message->file)
                                                            @if (Str::contains($message->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                                                <img src="{{ asset('storage/' . $message->file) }}" alt="Message Attachment" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                            @elseif (Str::contains($message->file, ['.pdf']))
                                                                <iframe src="{{ asset('storage/' . $message->file) }}" style="width: 50px; height: 50px;"></iframe>
                                                            @endif
                                                            <br>
                                                            <span>
                                                                <a wire:click="downloadFile({{ $message->id }}, '{{$message->file}}')" class="delete-message-btn" title="Download File">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                                    </svg>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </span>
                                                            <span>
                                                                 @if (!$message->message_text || !Str::contains($message->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                                                    @if (Str::contains($message->file, ['.pdf']))
                                                                    @else
                                                                        <a wire:click="viewFile({{ $message->id }}, '{{$message->file}}')" class="delete-message-btn" title="View File">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                                            </svg>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            </span>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <span>
                                                                    <a wire:click="deleteId({{ $message->id }}, '{{$message->file}}')" class="delete-message-btn" title="Delete Message">
                                                                        <span style="display: inline-block; cursor: pointer; color: black;" onmouseover="this.style.color='red'" onmouseout="this.style.color='black'">
                                                                            &#10005;
                                                                        </span>
                                                                    </a>
                                                                </span>

                                                        @endif
                                                    </p>

                                                </div>
                                                <img src="{{ URL::asset('photos/' . auth()->user()->photo) }}" alt="User Photo" style="width: 40px; height: 40px; border-radius: 50%;">
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <p class="small mb-0 text-muted mr-3">{{ $message->created_at->diffForHumans(null, false, false)}}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                            <form wire:submit.prevent="sendMessage" class="w-100">
                                <div class="input-group">
                                    <input type="text" class="form-control rounded-pill bg-light" wire:model.defer="messageText" onkeydown='scrollDown()' placeholder="Type your message here..." style="flex: 1;">
                                    <input type="file" wire:model="photos" accept="image/*, .pdf, .doc, .docx, .txt" multiple class="form-control d-none" id="photoInput">
                                    <label for="photoInput" class="btn btn-light rounded-pill ml-2" style="box-shadow: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                                            <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
                                        </svg>
                                    </label>
                                    <button class="btn btn-warning rounded-pill py-2" type="submit" style="box-shadow: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cursor-fill" viewBox="0 0 16 16">
                                            <path d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103z"/>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div><!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMessageModalLabel">Delete Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this message?
            </div>
            <div class="modal-footer">
                <button type="button" class="px-4 py-2 mr-2 text-white bg-red-500 rounded" wire:click="deleteMessage">Delete</button>
                <button type="button" class="px-4 py-2 text-black bg-gray-300 rounded" data-bs-dismiss="modal" wire:click="cancelDelete">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ... Your previous code ... -->

<script>
    window.addEventListener('showDeleteMessageModal', event => {
        $('#deleteMessageModal').modal('show');
    });

    window.addEventListener('hideDeleteMessageModal', event => {
        $('#deleteMessageModal').modal('hide');
    });
</script>

<!-- ... Your previous code ... -->
