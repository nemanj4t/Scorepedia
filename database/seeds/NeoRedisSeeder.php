<?php

use Illuminate\Database\Seeder;
use Ahsan\Neo4j\Facade\Cypher;

class NeoRedisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = Cypher::run(
            "CREATE (p1:Player {bio: 'bio', city: 'Paracin', height: 198, weight: 84, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/4192.png', name: 'Milos Teodosic'})
             CREATE (p2:Player {bio: 'bio', city: 'Nis', height: 216, weight: 108, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/4376.png', name: 'Boban Marjanovic'})
             CREATE (p3:Player {bio: 'bio', city: 'New York', height: 202, weight: 95, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/6440.png', name: 'Tobias Harris'})
             CREATE (p4:Player {bio: 'bio', city: 'San Francisco', height: 192, weight: 81, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/3975.png', name: 'Steph Curry'})
             CREATE (p5:Player {bio: 'bio', city: 'San Francisco', height: 200, weight: 89, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/6475.png', name: 'Klay Thompson'})
             CREATE (p6:Player {bio: 'bio', city: 'San Francisco', height: 210, weight: 95, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/3202.png', name: 'Kevin Durant'})
             CREATE (p7:Player {bio: 'bio', city: 'Dallas', height: 208, weight: 92, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/609.png', name: 'Dirk Nowitzki'})
             CREATE (p8:Player {bio: 'bio', city: 'Dallas', height: 201, weight: 90, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/3945274.png', name: 'Luka Doncic'})
             CREATE (p9:Player {bio: 'bio', city: 'Dallas', height: 209, weight: 101, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/3442.png', name: 'Deandre Jordan'})
             CREATE (t1:Team {name: 'LA Clippers', short_name: 'LAC', image: 'https://a.espncdn.com/combiner/i?img=%2Fi%2Fteamlogos%2Fnba%2F500%2Flac.png', description: 'description', background_image: 'https://i.pinimg.com/originals/10/a3/6d/10a36d46ec8c6df8fe54185c07418ff2.jpg', city: 'Los Angeles'})
             CREATE (t2:Team {name: 'Golden State Warriors', short_name: 'GSW', image: 'https://upload.wikimedia.org/wikipedia/sr/thumb/0/01/Golden_State_Warriors_logo.svg/838px-Golden_State_Warriors_logo.svg.png', description: 'description', background_image: 'https://usatftw.files.wordpress.com/2016/04/warriors21.png', city: 'San Francisco'})
             CREATE (t3:Team {name: 'Dallas Mavericks', short_name: 'DAL', image: 'https://seeklogo.com/images/D/dallas-mavericks-logo-BAA5E9D070-seeklogo.com.png', description: 'description', background_image: 'https://i.pinimg.com/originals/2e/04/fb/2e04fb2a40938a2964facf0d877ccbcd.jpg', city: 'Dallas'})
             CREATE (c1:Coach {bio: 'bio', city: 'Dallas', image: 'http://www.rantsports.com/nba/files/2014/01/Rick-Carlisle.jpg', name: 'Rick Carlisle'})
             CREATE (c2:Coach {bio: 'bio', city: 'San Francisco', image: 'https://statics.sportskeeda.com/wp-content/uploads/2015/04/465891240-1427918760.jpg', name: 'Steve Kerr'})
             CREATE (c3:Coach {bio: 'bio', city: 'City', image: 'https://img.bleacherreport.net/img/images/photos/003/266/302/3a2b30a737b8da1c2ce976dba5fd403c_crop_north.jpg', name: 'Doc Rivers'})
             CREATE (c4:Coach {bio: 'bio', city: 'City', image: 'https://img.bleacherreport.net/img/images/photos/003/584/311/hi-res-efda11088d479e1844412e3dcadd4540_crop_north.jpg', name: 'Luke Walton'})
             CREATE (c5:Coach {bio: 'bio', city: 'City', image: 'https://wtop.com/wp-content/uploads/2015/12/Pistons-76ers-Basketball-727x485.jpeg', name: 'Brett Brown'})
             CREATE (c6:Coach {bio: 'bio', city: 'City', image: 'https://www.nba.com/rockets/sites/rockets/files/dantoni.jpg', name: 'Mike Antoni'})
             CREATE (p1)-[:PLAYS {number: 12, played_since: '2019-01-06', position: 'PF'}]->(t1)
             CREATE (p2)-[:PLAYS {number: 18, played_since: '2019-01-06', position: 'PG'}]->(t1)
             CREATE (p3)-[:PLAYS {number: 2, played_since: '2019-01-06', position: 'C'}]->(t1)
             CREATE (p4)-[:PLAYS {number: 45, played_since: '2019-01-06', position: 'PF'}]->(t2)
             CREATE (p5)-[:PLAYS {number: 25, played_since: '2019-01-06', position: 'PG'}]->(t2)
             CREATE (p6)-[:PLAYS {number: 9, played_since: '2019-01-06', position: 'C'}]->(t2)
             CREATE (p7)-[:PLAYS {number: 91, played_since: '2019-01-06', position: 'PF'}]->(t3)
             CREATE (p8)-[:PLAYS {number: 16, played_since: '2019-01-06', position: 'PG'}]->(t3)
             CREATE (p9)-[:PLAYS {number: 50, played_since: '2019-01-06', position: 'C'}]->(t3)
             CREATE (t1)-[:TEAM_COACH {coached_since: '2019-01-06', coached_until: '2019-01-30'}]->(c1)
             CREATE (t2)-[:TEAM_COACH {coached_since: '2019-01-06', coached_until: '2019-01-30'}]->(c2)
             CREATE (t3)-[:TEAM_COACH {coached_since: '2019-01-06', coached_until: '2019-01-30'}]->(c3)
             RETURN ID(t1), ID(t2), ID(t3)"
        );

        foreach ($query->firstRecord()->values() as $id) {
            Redis::zadd("points", 0, $id);
            Redis::zadd("wins", 0, $id);
            Redis::zadd("losses", 0, $id);
            Redis::zadd("percentage", 0, $id);
            Redis::zadd("home", 0, $id);
            Redis::zadd("road", 0, $id);
            Redis::zadd("streak", 0, $id);

            Redis::hmset(
                "team:standings:{$id}",
                "points", 0,
                "wins", 0,
                "losses", 0,
                "percentage", 0,
                "home", 0,
                "road", 0,
                "streak", 0);
        }

        Redis::set('user:count', 0);
        Redis::set('count:logins', 0);
        Redis::set('count:matches', 0);
        Redis::set('count:players', 9);
        Redis::set('count:coaches', 6);
        Redis::set('count:teams', 3);
        Redis::set('count:comments', 0);
        Redis::set('count:articles', 0);
    }
}
