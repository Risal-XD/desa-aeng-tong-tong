<?php

namespace Tests\Unit;

use App\Enums\MessageStatus;
use App\Models\Message;
use App\Models\User;
use App\Models\Village;
use App\Services\MessageService;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(VillageSeeder::class);
    }

    public function test_store_membuat_pesan_dengan_status_baru(): void
    {
        $message = app(MessageService::class)->store([
            'name' => 'Pengirim Test',
            'email' => 'pengirim@test.com',
            'phone' => '081234567890',
            'subject' => 'Subjek',
            'message' => 'Isi pesan',
        ]);

        $this->assertSame(MessageStatus::BARU, $message->status);
        $this->assertSame(Village::query()->orderBy('id')->first()->getKey(), $message->village_id);
        $this->assertNull($message->reply);
    }

    public function test_store_tanpa_phone_menyimpan_null(): void
    {
        $message = app(MessageService::class)->store([
            'name' => 'Pengirim Test',
            'email' => 'pengirim@test.com',
            'subject' => 'Subjek',
            'message' => 'Isi pesan',
        ]);

        $this->assertNull($message->phone);
    }

    public function test_mark_read_hanya_mengubah_pesan_baru(): void
    {
        $village = Village::query()->orderBy('id')->first();

        $message = Message::create([
            'village_id' => $village->getKey(),
            'name' => 'Pengirim',
            'email' => 'a@test.com',
            'subject' => 'Subjek',
            'message' => 'Isi',
            'status' => 'baru',
        ]);

        app(MessageService::class)->markRead($message);

        $this->assertSame(MessageStatus::DIBACA, $message->refresh()->status);
    }

    public function test_mark_read_tidak_mengubah_status_selain_baru(): void
    {
        $village = Village::query()->orderBy('id')->first();

        $message = Message::create([
            'village_id' => $village->getKey(),
            'name' => 'Pengirim',
            'email' => 'a@test.com',
            'subject' => 'Subjek',
            'message' => 'Isi',
            'status' => 'dibalas',
            'reply' => 'Balasan lama',
        ]);

        app(MessageService::class)->markRead($message);

        $this->assertSame(MessageStatus::DIBALAS, $message->refresh()->status);
    }

    public function test_reply_mengisi_balasan_dan_waktu(): void
    {
        $user = User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();
        $village = Village::query()->orderBy('id')->first();

        $message = Message::create([
            'village_id' => $village->getKey(),
            'name' => 'Pengirim',
            'email' => 'a@test.com',
            'subject' => 'Subjek',
            'message' => 'Isi',
            'status' => 'baru',
        ]);

        $this->actingAs($user);
        app(MessageService::class)->reply($message, 'Terima kasih.');

        $message->refresh();

        $this->assertSame(MessageStatus::DIBALAS, $message->status);
        $this->assertSame('Terima kasih.', $message->reply);
        $this->assertNotNull($message->replied_at);
        $this->assertSame($user->getKey(), $message->user_id);
        $this->assertTrue($message->isReplied());
    }

    public function test_is_replied_false_saat_status_selain_dibalas(): void
    {
        $village = Village::query()->orderBy('id')->first();

        $message = Message::create([
            'village_id' => $village->getKey(),
            'name' => 'Pengirim',
            'email' => 'a@test.com',
            'subject' => 'Subjek',
            'message' => 'Isi',
            'status' => 'dibaca',
        ]);

        $this->assertFalse($message->isReplied());
    }
}
