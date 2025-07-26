<?php

namespace App\Livewire;

use App\Models\ProceduralRecord;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ProceduralRecordShow extends Component
{
    public $proceduralRecord;
    public $case_id;

    public function mount($id, $case_id = null)
    {
        $this->proceduralRecord = ProceduralRecord::with(['case.client', 'files'])->findOrFail($id);
        $this->case_id = $case_id;
    }

    public function downloadFile($fileId)
    {
        $file = $this->proceduralRecord->files->find($fileId);

        if ($file && Storage::disk('public')->exists($file->file_path)) {
            return response()->download(storage_path('app/public/' . $file->file_path));
        }

        session()->flash('error', 'الملف غير موجود.');
        return null;
    }

    public function render()
    {
        return view('livewire.procedural-record-show');
    }
}
