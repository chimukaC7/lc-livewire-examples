<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Mail\ContactFormMailable;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Component
{
    //You can use both livewire:make and make:livewire to create the component

    //the state that you need
    public $name;
    public $email;
    public $phone;
    public $message;

    //if you don't want to use flash, you can use a piece of state that holds the flash message
    public $successMessage;

    //when rules are defined as property or instance variable, you no longer need to pass them
    protected $rules = [
        'name' => 'required',
        'email' => ['required','email'],
        'phone' => 'required',
        'message' => ['required','min:5'],
    ];

    //using a hook
    //whenever any the stats changes this method is called
    public function updated($propertyName)//whatever was updated
    {
        $this->validateOnly($propertyName);
    }

    public function submitForm()
    {
        //You can also leave out the following part:
        // $contact['name'] = $this->name;
        // $contact['email'] = $this->email;
        // $contact['phone'] = $this->phone;
        // $contact['message'] = $this->message;

        //if you use $contact = $this->validate instead of $contact = $request->validate
        $contact = $this->validate();

        sleep(1);
        Mail::to('andre@andre.com')->send(new ContactFormMailable($contact));

        //if you do not want to use flash
        $this->successMessage = 'We received your message successfully and will get back to you shortly!';
        // session()->flash('success_message', 'We received your message successfully and will get back to you shortly!');

        //since we are not redirecting, we use reset the form
        //there is no full page refresh

        //Instead of using the private function resetForm() you can use $this->reset() in the public function submitForm().
        $this->resetForm();

        //You can pass an array to the reset method that contains the properties that you want to reset.
        //If nothing is passed, then all of them get reset
        //$this->reset(['name', 'email', 'phone', 'message']);
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
