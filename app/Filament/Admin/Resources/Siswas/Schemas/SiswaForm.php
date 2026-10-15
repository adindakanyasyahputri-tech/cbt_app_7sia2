<?php

namespace App\Filament\Admin\Resources\Siswas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        FileUpload::make('foto_path')
                            ->label('Foto siswa')
                            ->avatar()
                            ->image()
                            ->alignCenter()
                            ->columnSpanFull()
                            ->disk('public')
                            ->directory('siswa')
                            ->imageEditor()
                            ->deletable()
                            ->openable(),

                        TextInput::make('name')
                            ->label('Nama lengkap')
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('nisn')
                            ->label('NISN')
                            ->helperText('Digunakan sebagai username login siswa')
                            ->required()
                            ->unique('siswas', 'nisn'),

                        TextInput::make('kelas')
                            ->label('Kelas'),

                        TextInput::make('email')
                            ->label('Alamat email')
                            ->email()
                            ->unique('siswas', 'email'),

                        Select::make('jenis_kelamin')
                          ->label('Jenis kelamin')
                          ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                         ])
                        ->required(),
                        
                        TextInput::make('tempat_lahir')
                            ->label('Tempat lahir'),

                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal lahir'),

                        TextInput::make('no_hp')
                            ->label('No. HP'),

                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->columnSpanFull(),
                    ]),

                Section::make('Akun Login')
                    ->columnSpanFull()
                    ->description('Akun dibuat otomatis saat menyimpan. Login memakai NISN dan kata sandi di bawah.')
                    ->schema([
                        TextInput::make('login_password')
                            ->label('Kata sandi akun')
                            ->password()
                            ->revealable()
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->dehydrated()
                            ->helperText('Kosongkan saat edit untuk mempertahankan kata sandi lama'),
                    ]),
            ]);
    }
}
