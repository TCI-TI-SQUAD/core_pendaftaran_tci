<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\PengumumanGlobal;

class CreatePengumumanGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengumuman_globals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_admin');
            $table->text('pengumuman');
            $table->date('tanggal');
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        PengumumanGlobal::insert([
            [
                'id_admin' => 1,
                'pengumuman' => '<h5>PENGUMUMAN GLOBAL</h5><p> <strong>Apollo 11</strong> was the spaceflight that landed the first humans, Americans <a href="http://en.wikipedia.org/wiki/Neil_Armstrong">Neil Armstrong</a> and <a href="http://en.wikipedia.org/wiki/Buzz_Aldrin">Buzz Aldrin</a>, on the Moon on July 20, 1969, at 20:18 UTC. Armstrong became the first to step onto the lunar surface 6 hours later on July 21 at 02:56 UTC.</p><p> Armstrong spent about <s>three and a half</s> two and a half hours outside the spacecraft, Aldrin slightly less; and together they collected 47.5 pounds (21.5&nbsp;kg) of lunar material for return to Earth. A third member of the mission, <a href="http://en.wikipedia.org/wiki/Michael_Collins_(astronaut)">Michael Collins</a>, piloted the <a href="http://en.wikipedia.org/wiki/Apollo_Command/Service_Module">command</a> spacecraft alone in lunar orbit until Armstrong and Aldrin returned to it for the trip back to Earth.</p><h2> Broadcasting and <em>quotes</em> <a id="quotes" name="quotes"></a></h2><p> Broadcast on live TV to a world-wide audience, Armstrong stepped onto the lunar surface and described the event as:</p><blockquote><p> One small step for [a] man, one giant leap for mankind.</p></blockquote><h2> Technical details <a id="tech-details" name="tech-details"></a></h2><table align="right" border="1" bordercolor="#ccc" cellpadding="5" cellspacing="0" style="border-collapse:collapse"><caption> <strong>Mission crew</strong></caption><thead><tr><th scope="col"> Position</th><th scope="col"> Astronaut</th></tr></thead><tbody><tr><td> Commander</td><td> Neil A. Armstrong</td></tr><tr><td> Command Module Pilot</td><td> Michael Collins</td></tr><tr><td> Lunar Module Pilot</td><td> Edwin &quot;Buzz&quot; E. Aldrin, Jr.</td></tr></tbody></table><p> Launched by a <strong>Saturn V</strong> rocket from <a href="http://en.wikipedia.org/wiki/Kennedy_Space_Center">Kennedy Space Center</a> in Merritt Island, Florida on July 16, Apollo 11 was the fifth manned mission of <a href="http://en.wikipedia.org/wiki/NASA">NASA</a>&#39;s Apollo program. The Apollo spacecraft had three parts:</p><ol><li> <strong>Command Module</strong> with a cabin for the three astronauts which was the only part which landed back on Earth</li><li> <strong>Service Module</strong> which supported the Command Module with propulsion, electrical power, oxygen and water</li><li> <strong>Lunar Module</strong> for landing on the Moon.</li></ol><p> After being sent to the Moon by the Saturn V&#39;s upper stage, the astronauts separated the spacecraft from it and travelled for three days until they entered into lunar orbit. Armstrong and Aldrin then moved into the Lunar Module and landed in the <a href="http://en.wikipedia.org/wiki/Mare_Tranquillitatis">Sea of Tranquility</a>. They stayed a total of about 21 and a half hours on the lunar surface. After lifting off in the upper part of the Lunar Module and rejoining Collins in the Command Module, they returned to Earth and landed in the <a href="http://en.wikipedia.org/wiki/Pacific_Ocean">Pacific Ocean</a> on July 24.</p><hr><p> <small>Source: <a href="http://en.wikipedia.org/wiki/Apollo_11">Wikipedia.org</a></small></p>',
                'tanggal' => date('Y-m-d'),
            ],
        ]);
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengumuman_globals');
    }
}