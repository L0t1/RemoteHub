<?php

namespace App\Policies;

use App\Models\Office;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfficePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Office $office)
    {
        return $user->id == $office->user_id;
    }

     /**
     * @test
     */
    public function itDoesntUpdateOfficeThatDoesntBelongToUser()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $office = Office::factory()->for($anotherUser)->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/offices/'.$office->id, [
            'title' => 'Amazing Office'
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}