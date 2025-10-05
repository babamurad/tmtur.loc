    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_group_id')->constrained()->cascadeOnDelete(); // ← раскомментировать
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();   // ← раскомментировать
            $table->unsignedTinyInteger('people_count');
            $table->unsignedInteger('total_price_cents');
            $table->enum('status', ['pending','confirmed','done','cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->timestamps();

            $table->index(['tour_group_id','status']); // ← раскомментировать
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
