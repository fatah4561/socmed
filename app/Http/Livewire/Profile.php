<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;

class Profile extends Component
{
	use WithFileUploads;
    /**
     * inisialisasi data kosong
     */
    public $user_id,
    $user,
    $name,
    $bio,
    $username,
    $email,
    $type,
    $password,
    $second_password,
    $profile_pic,
    $university,
    $address,
    $file,
    $update_mode,
    $is_disabled,
    $edit_button;

    /**
     * render() ialah function yang digunakan untuk mereturn view
     */
    public function render()
    {
        return view('livewire.profile.profile')->extends('livewire.profile.index')->section('content');
    }

    /**
     * mount() ialah function yang dijalankan 1x ketika halaman dibuka,
     * mount akan mengisikan variabel dengan nilai yang diinginkan (inisialisasi data)
     */
    public function mount($id)
    {
        $this->is_disabled = "disabled";
        $this->edit_button = "Edit";
        $this->file = "";

        $this->user_id = $id;
        $this->user = User::where('id', $id)->first();
        $this->name = $this->user->name;
        $this->bio = $this->user->bio;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->password = $this->user->password;
        $this->profile_pic = $this->user->profile_pic;
    }

    /**
     * clear() function yang digunakan untuk mereset inputan dan merefresh data
     */
    public function clear()
    {
        $this->edit_button = "Edit";
        $this->is_disabled = "disabled";
        $this->file = "";
        $this->user = User::where('id', $this->user_id)->first();
        $this->password = $this->user->password;
        $this->second_password = "";

    }

    /**
     * update() function untuk memasuki update mode profile dan melakukan perubahan
     * data profile termasuk bio
     */
    public function update()
    {
        if($this->is_disabled == "disabled"){
            $this->password = "";
            $this->is_disabled = "";
            $this->edit_button = "Simpan";
        }elseif($this->is_disabled == ""){
            
            if($this->second_password != $this->password){
                $this->addError('password', 'Password tidak sama!');
                $this->addError('second_password', 'Password tidak sama!');
            }else{

                
                if($this->file != "" ){
                    $exists_file = Storage::files(Storage::url($this->profile_pic));
                    if($exists_file){
                        Storage::delete($this->profile_pic);
                    }

                    $filename = $this->user->name."_profile";
                    $file_extension = explode('.' , $this->file->getClientOriginalName())[1];
                    $stored_path = $this->file->storePubliclyAs('uploads/user', $filename.".".$file_extension, 'public');
                    $this->profile_pic = $stored_path;
                    
                    $this->user->update([
                        "profile_pic" => $stored_path,
                    ]);
                }
                
    
                $this->user->update([
                    "name" => $this->name,
                    "username" => $this->username,
                    "email" => $this->email,
                    "password" => Hash::make($this->password),
                    "bio" => $this->bio,
                ]);
                $this->password = Hash::make($this->password);
                $this->clear();
                session()->flash('message', 'Data akun berhasil diubah.');
            }


        }
    }
}
