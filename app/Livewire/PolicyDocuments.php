<?php
namespace App\Livewire;

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

#[Layout('layouts.app')]
class PolicyDocuments extends Component
{
    public $policies = [];
    public $selectedPolicyId = '';
    public $documentUrl = '';

    public function mount()
    {
        $this->policies = InsurancePolicy::where('user_id', Auth::id())->get();
    }

    public function generateDocument($policyId)
    {
        $policy = InsurancePolicy::findOrFail($policyId);
        try {
            // Placeholder: Generate PDF logic here
            $pdfContent = "Policy Document for #{$policy->policy_number}";
            $fileName = "policy_documents/{$policy->policy_number}.pdf";
            Storage::disk('public')->put($fileName, $pdfContent);
            $this->documentUrl = Storage::disk('public')->url($fileName);
            session()->flash('success', 'Policy document generated and stored.');
        } catch (Exception $e) {
            Log::error('Policy document generation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to generate policy document.');
        }
    }

    public function downloadDocument($policyId)
    {
        $policy = InsurancePolicy::findOrFail($policyId);
        $fileName = "policy_documents/{$policy->policy_number}.pdf";
        if (Storage::disk('public')->exists($fileName)) {
            return response()->download(storage_path("app/public/{$fileName}"));
        } else {
            session()->flash('error', 'Document not found.');
        }
    }
}
