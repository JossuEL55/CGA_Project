    <?php

    use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('validaciones', function (Blueprint $table) {
            $table->increments('id_validacion');

            $table->unsignedInteger('id_orden');
            $table->foreign('id_orden')
                  ->references('id_orden')
                  ->on('ordenes_tecnicas')
                  ->onDelete('cascade');

            $table->unsignedInteger('id_supervisor')->nullable();
            $table->foreign('id_supervisor')
                  ->references('id_tecnico')
                  ->on('tecnicos')
                  ->onDelete('set null');

            $table->string('estado_validacion', 50);
            $table->text('comentarios')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('validaciones');
    }
};

