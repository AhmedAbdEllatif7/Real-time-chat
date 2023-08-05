<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Chat extends Component
{
    use WithFileUploads;

    public $messageText;
    public $messageToDeleteId;
    public $photos = [];
    public $deleteId = '';

    public function render()
    {
        $messages = Message::with('user')->latest()->get()->sortBy('id');

        return view('livewire.chat', compact('messages'));
    }

    public function sendMessage()
    {
        $messageText = trim($this->messageText); // Remove leading and trailing whitespace

        $this->validate([
            'photos.*' => 'nullable|file|mimes:jpeg,png,gif,pdf,doc,docx,txt|max:2048', // Add appropriate file validation rules here
        ]);


        if (!empty($this->photos)) {
            foreach ($this->photos as $photo) {
                $photoPath = $photo->store('attachment', 'public'); // Store each photo in the 'public/attachment' directory
                Message::create([
                    'user_id' => auth()->user()->id,
                    'message_text' => $messageText,
                    'file' => $photoPath,
                ]);
            }
        }

        if (!empty($messageText)) {
            Message::create([
                'user_id' => auth()->user()->id,
                'message_text' => $messageText,
            ]);
        }

        $this->reset(['messageText', 'photos']);
    }



    // Assuming you have the `public_path()` helper function available.
    public function downloadFile($id, $file)
    {
        $filePath = public_path('storage/' . $file);

        if (file_exists($filePath)) {
            // Get the MIME type of the file (e.g., 'image/jpeg', 'image/png', etc.)
            $mimeType = mime_content_type($filePath);

            // Set the appropriate response headers to display the image in the browser
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }




    public function deleteId($id , $fileName)
    {
        $message = Message::find($id);

        if ($message) {
            // Delete the message record from the database
            $message->delete();

            // Delete the associated file from storage if it exists
            $filePath = public_path('storage/' . $fileName);
            if (file_exists($filePath)) {
                Storage::disk('public')->delete($fileName);
            }

            // Optionally, you can add a success message or redirect back to the page
            return redirect()->back()->with('success', 'Message deleted successfully.');
        } else {
            // Message not found in the database, you can handle this case as per your requirement
            return response()->json(['error' => 'Message not found'], 404);
        }
    }



    public function viewFile($id , $fileName)
    {
        $filePath = public_path('storage/' . $fileName);

        if (file_exists($filePath)) {
            $filename = basename($filePath); // Get the file name from the path

            return response()->download($filePath, $filename);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }


}
