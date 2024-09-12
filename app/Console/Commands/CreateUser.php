<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UnidadNegocioModel;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear un nuevo usuario';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $unidades = UnidadNegocioModel::all(['id', 'area']);

        if ($unidades->isEmpty()) {
            $this->error('No hay unidades de negocio disponibles (Ejecutar seeders).');
            return 1;
        }

        $nombre = $this->ask('Ingresar nombre.');
        $email = $this->ask('Ingresar email.');

        $this->info('Selecciona la unidad de negocio');
        $this->info('Unidades disponibles:');
        $this->info('1 = iTRENDS');
        $this->info('2 = Area 59');

        $udn = $this->ask('Introducir el ID de la unidad de negocio');

        if (!$unidades->contains('id', $udn)) {
            $this->error('Unidad de negocio no válida. Intente otra vez.');
            return 1;
        }

        $password = $this->secret('Ingresar una contraseña');
        $passwordConfirm = $this->secret('Repita la contraseña');

        if ($password !== $passwordConfirm) {
            $this->error('La contraseña no coincide. Intente otra vez.');
            return 1;
        }

        $user = User::create([
            'nombre' => $nombre,
            'email' => $email,
            'udn' => $udn,
            'password' => Hash::make($password),
            'email_verified_at' => null,
        ]);

        $this->info('Usuario creado con éxito con ID ' . $user->id);
        return 0;
    }
}