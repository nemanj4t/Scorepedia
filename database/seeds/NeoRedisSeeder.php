<?php

use Illuminate\Database\Seeder;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Support\Facades\Redis;

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
            "CREATE (a:Admin {email: 'admin@admin.com', password: '$2y$10\$Aczc2Cyxdho1jWzRpOyTdeAOKmj48LYuCxGGhF7.dJqfaII.jN2HW', token: ''})
             CREATE (p1:Player {bio: 'bio', city: 'Paracin', height: 198, weight: 84, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/4192.png', name: 'Milos Teodosic'})
             CREATE (p2:Player {bio: 'bio', city: 'Nis', height: 216, weight: 108, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/4376.png', name: 'Boban Marjanovic'})
             CREATE (p3:Player {bio: 'bio', city: 'New York', height: 202, weight: 95, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/6440.png', name: 'Tobias Harris'})
             CREATE (p4:Player {bio: 'bio', city: 'San Francisco', height: 192, weight: 81, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/3975.png', name: 'Steph Curry'})
             CREATE (p5:Player {bio: 'bio', city: 'San Francisco', height: 200, weight: 89, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/6475.png', name: 'Klay Thompson'})
             CREATE (p6:Player {bio: 'bio', city: 'San Francisco', height: 210, weight: 95, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/3202.png', name: 'Kevin Durant'})
             CREATE (p7:Player {bio: 'bio', city: 'Dallas', height: 208, weight: 92, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/609.png', name: 'Dirk Nowitzki'})
             CREATE (p8:Player {bio: 'bio', city: 'Dallas', height: 201, weight: 90, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/3945274.png', name: 'Luka Doncic'})
             CREATE (p9:Player {bio: 'bio', city: 'Dallas', height: 209, weight: 101, image: 'http://a.espncdn.com/combiner/i?img=/i/headshots/nba/players/full/3442.png', name: 'Deandre Jordan'})
             CREATE (p10:Player {bio: 'bio', city: 'Paracin', height: 198, weight: 84, image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Player Test1'})
             CREATE (p11:Player {bio: 'bio', city: 'Nis', height: 216, weight: 108, image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Player Test2'})
             CREATE (p12:Player {bio: 'bio', city: 'New York', height: 202, weight: 95, image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Player Test3'})
             CREATE (p13:Player {bio: 'bio', city: 'San Francisco', height: 192, weight: 81, image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Player Test4'})
             CREATE (p14:Player {bio: 'bio', city: 'San Francisco', height: 200, weight: 89, image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Player Test5'})
             CREATE (p15:Player {bio: 'bio', city: 'San Francisco', height: 210, weight: 95, image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Player Test6'})
             CREATE (p16:Player {bio: 'bio', city: 'Dallas', height: 208, weight: 92, image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Player Test7'})
             CREATE (p17:Player {bio: 'bio', city: 'Dallas', height: 201, weight: 90, image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Player Test8'})
             CREATE (p18:Player {bio: 'bio', city: 'Dallas', height: 209, weight: 101, image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Player Test9'})
             CREATE (t1:Team {name: 'LA Clippers', short_name: 'LAC', image: 'https://a.espncdn.com/combiner/i?img=%2Fi%2Fteamlogos%2Fnba%2F500%2Flac.png', description: 'description', background_image: 'https://i.pinimg.com/originals/10/a3/6d/10a36d46ec8c6df8fe54185c07418ff2.jpg', city: 'Los Angeles'})
             CREATE (t2:Team {name: 'Golden State Warriors', short_name: 'GSW', image: 'https://upload.wikimedia.org/wikipedia/sr/thumb/0/01/Golden_State_Warriors_logo.svg/838px-Golden_State_Warriors_logo.svg.png', description: 'description', background_image: 'https://usatftw.files.wordpress.com/2016/04/warriors21.png', city: 'San Francisco'})
             CREATE (t3:Team {name: 'Dallas Mavericks', short_name: 'DAL', image: 'https://seeklogo.com/images/D/dallas-mavericks-logo-BAA5E9D070-seeklogo.com.png', description: 'description', background_image: 'https://i.pinimg.com/originals/2e/04/fb/2e04fb2a40938a2964facf0d877ccbcd.jpg', city: 'Dallas'})
             CREATE (t4:Team {name: 'Team Test1', short_name: 'TST1', image: 'https://pngimage.net/wp-content/uploads/2018/06/team-png-icon.png', description: 'description', background_image: 'https://upload.wikimedia.org/wikipedia/commons/a/a7/Future_earth.jpg', city: 'Test'})
             CREATE (t5:Team {name: 'Team Test2', short_name: 'TST2', image: 'https://pngimage.net/wp-content/uploads/2018/06/team-png-icon.png', description: 'description', background_image: 'https://upload.wikimedia.org/wikipedia/commons/a/a7/Future_earth.jpg', city: 'Test'})
             CREATE (t6:Team {name: 'Team Test3', short_name: 'TST3', image: 'https://pngimage.net/wp-content/uploads/2018/06/team-png-icon.png', description: 'description', background_image: 'https://upload.wikimedia.org/wikipedia/commons/a/a7/Future_earth.jpg', city: 'Test'})
             CREATE (c1:Coach {bio: 'bio', city: 'Dallas', image: 'http://www.rantsports.com/nba/files/2014/01/Rick-Carlisle.jpg', name: 'Rick Carlisle'})
             CREATE (c2:Coach {bio: 'bio', city: 'San Francisco', image: 'https://statics.sportskeeda.com/wp-content/uploads/2015/04/465891240-1427918760.jpg', name: 'Steve Kerr'})
             CREATE (c3:Coach {bio: 'bio', city: 'City', image: 'https://ioneblackamericaweb.files.wordpress.com/2018/06/docrivers.jpg', name: 'Doc Rivers'})
             CREATE (c4:Coach {bio: 'bio', city: 'City', image: 'http://a.espncdn.com/photo/2017/0202/r177390_1600x800cc.jpg', name: 'Luke Walton'})
             CREATE (c5:Coach {bio: 'bio', city: 'City', image: 'https://wtop.com/wp-content/uploads/2015/12/Pistons-76ers-Basketball-727x485.jpeg', name: 'Brett Brown'})
             CREATE (c6:Coach {bio: 'bio', city: 'City', image: 'https://www.nba.com/rockets/sites/rockets/files/dantoni.jpg', name: 'Mike Antoni'})
             CREATE (c7:Coach {bio: 'bio', city: 'City', image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Coach Test1'})
             CREATE (c8:Coach {bio: 'bio', city: 'City', image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Coach Test2'})
             CREATE (c9:Coach {bio: 'bio', city: 'City', image: 'http://pkf.kiev.ua/wp-content/themes/pkf-audit-finance/content_images/unknown_person.png', name: 'Coach Test3'})
             CREATE (p1)-[:PLAYS {number: 12, played_since: '2019-01-06', position: 'PF'}]->(t1)
             CREATE (p2)-[:PLAYS {number: 18, played_since: '2019-01-06', position: 'PG'}]->(t1)
             CREATE (p3)-[:PLAYS {number: 2, played_since: '2019-01-06', position: 'C'}]->(t1)
             CREATE (p4)-[:PLAYS {number: 45, played_since: '2019-01-06', position: 'PF'}]->(t2)
             CREATE (p5)-[:PLAYS {number: 25, played_since: '2019-01-06', position: 'PG'}]->(t2)
             CREATE (p6)-[:PLAYS {number: 9, played_since: '2019-01-06', position: 'C'}]->(t2)
             CREATE (p7)-[:PLAYS {number: 91, played_since: '2019-01-06', position: 'PF'}]->(t3)
             CREATE (p8)-[:PLAYS {number: 16, played_since: '2019-01-06', position: 'PG'}]->(t3)
             CREATE (p9)-[:PLAYS {number: 50, played_since: '2019-01-06', position: 'C'}]->(t3)
             CREATE (p10)-[:PLAYS {number: 4, played_since: '2019-01-06', position: 'C'}]->(t4)
             CREATE (p11)-[:PLAYS {number: 11, played_since: '2019-01-06', position: 'PG'}]->(t4)
             CREATE (p12)-[:PLAYS {number: 12, played_since: '2019-01-06', position: 'PF'}]->(t4)
             CREATE (p13)-[:PLAYS {number: 13, played_since: '2019-01-06', position: 'C'}]->(t5)
             CREATE (p14)-[:PLAYS {number: 14, played_since: '2019-01-06', position: 'PF'}]->(t5)
             CREATE (p15)-[:PLAYS {number: 15, played_since: '2019-01-06', position: 'PG'}]->(t5)
             CREATE (p16)-[:PLAYS {number: 16, played_since: '2019-01-06', position: 'C'}]->(t6)
             CREATE (p16)-[:PLAYS {number: 17, played_since: '2019-01-06', position: 'PF'}]->(t6)
             CREATE (p16)-[:PLAYS {number: 18, played_since: '2019-01-06', position: 'PG'}]->(t6)
             CREATE (t1)-[:TEAM_COACH {coached_since: '2019-01-06', coached_until: '2019-01-30'}]->(c1)
             CREATE (t2)-[:TEAM_COACH {coached_since: '2019-01-06', coached_until: '2019-01-30'}]->(c2)
             CREATE (t3)-[:TEAM_COACH {coached_since: '2019-01-06', coached_until: '2019-01-30'}]->(c3)
             CREATE (t4)-[:TEAM_COACH {coached_since: '2019-01-06', coached_until: '2019-01-30'}]->(c7)
             CREATE (t5)-[:TEAM_COACH {coached_since: '2019-01-06', coached_until: '2019-01-30'}]->(c8)
             CREATE (t6)-[:TEAM_COACH {coached_since: '2019-01-06', coached_until: '2019-01-30'}]->(c9)
             CREATE (a1:Article {image: 'https://cdn.vox-cdn.com/thumbor/sY9mfwVqGvLjlGWUk5X0HxEEpuM=/0x0:4130x3096/1200x800/filters:focal(1421x84:2081x744)/cdn.vox-cdn.com/uploads/chorus_image/image/60970725/usa_today_10729597.0.jpg', timestamp: '14-01-19 02:17:48', title: 'Test Title1', content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nisl at elit euismod pellentesque elementum ut sapien. Cras est nibh, rhoncus in nulla aliquam, iaculis sagittis nunc. Aenean suscipit accumsan quam, ut interdum erat ornare nec. Nullam ex orci, sollicitudin nec vehicula et, sollicitudin bibendum nisl. Donec vel ornare massa. Quisque pellentesque lacinia suscipit. Cras ornare nibh nunc, ut rutrum metus mollis efficitur. Vestibulum rutrum quam ut faucibus porta. In venenatis eros quam, nec rhoncus magna ullamcorper eu. Etiam vel sollicitudin sapien. Fusce eu massa non nisl lacinia ornare in vitae dolor. Pellentesque aliquet in odio tempor ornare. Vestibulum laoreet vehicula augue id volutpat. Quisque scelerisque massa nec purus mattis, eu porta nunc convallis. Aenean vehicula nibh at tellus dictum, ac viverra magna congue. Proin mollis nisi dolor, vel fermentum nunc iaculis sed. Sed aliquet, orci in sollicitudin tempus, tellus sem gravida eros, in euismod tellus ante a dolor. Sed scelerisque feugiat justo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc at nisl tincidunt, elementum lorem quis, sagittis mi. Maecenas imperdiet lacinia purus. Donec in odio a diam laoreet pharetra. Cras feugiat a nibh vel luctus. Donec dictum venenatis massa et iaculis. Proin luctus varius orci, a ultricies odio. Nulla non mattis lectus. Cras non suscipit quam, vitae tempus lectus. Pellentesque vel viverra tellus, nec scelerisque mauris. Nam purus neque, vehicula in consequat id, vulputate vel justo. Proin ornare tellus ut dignissim condimentum. Proin sit amet leo eget ligula sagittis consequat nec et ex. Quisque mi orci, porttitor eget porta vestibulum, dapibus sed turpis. Nullam vitae egestas justo. Etiam varius, augue sit amet fermentum dapibus, tellus elit feugiat ante, ac pretium libero sapien non velit. Nullam viverra lorem quis convallis feugiat. In nulla lectus, vestibulum et nisl fringilla, vulputate malesuada neque. Cras sagittis ligula lectus, vitae dignissim ex sollicitudin at. Praesent viverra efficitur enim vitae interdum. Suspendisse malesuada purus metus, consectetur fringilla tortor ultricies sit amet. Aliquam consectetur sapien quam. Integer sed orci ex. Vivamus est mi, efficitur quis leo nec, laoreet rutrum mi. Donec porta sapien est, sagittis dignissim elit luctus vitae. Praesent accumsan est a purus semper accumsan. Cras vel sapien magna. Maecenas quis mi eget ligula dapibus accumsan ut quis dolor. Proin eleifend dui eu orci porta rutrum. Nam vel congue eros, vitae vestibulum est. Sed tristique, magna a commodo posuere, dolor ex lacinia justo, sit amet semper felis nisi in nulla. Vestibulum in ultrices urna, id dictum dolor. Sed blandit euismod arcu, et volutpat nulla fringilla at. In nisi eros, convallis id posuere ac, dignissim in tortor. Morbi nisi velit, ornare ac accumsan nec, viverra ut nibh.'})
             CREATE (a2:Article {image: 'http://essay.iaspaper.net/wp-content/uploads/2018/05/Basketball.jpg', timestamp: '14-01-19 02:17:48', title: 'Test Title2', content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nisl at elit euismod pellentesque elementum ut sapien. Cras est nibh, rhoncus in nulla aliquam, iaculis sagittis nunc. Aenean suscipit accumsan quam, ut interdum erat ornare nec. Nullam ex orci, sollicitudin nec vehicula et, sollicitudin bibendum nisl. Donec vel ornare massa. Quisque pellentesque lacinia suscipit. Cras ornare nibh nunc, ut rutrum metus mollis efficitur. Vestibulum rutrum quam ut faucibus porta. In venenatis eros quam, nec rhoncus magna ullamcorper eu. Etiam vel sollicitudin sapien. Fusce eu massa non nisl lacinia ornare in vitae dolor. Pellentesque aliquet in odio tempor ornare. Vestibulum laoreet vehicula augue id volutpat. Quisque scelerisque massa nec purus mattis, eu porta nunc convallis. Aenean vehicula nibh at tellus dictum, ac viverra magna congue. Proin mollis nisi dolor, vel fermentum nunc iaculis sed. Sed aliquet, orci in sollicitudin tempus, tellus sem gravida eros, in euismod tellus ante a dolor. Sed scelerisque feugiat justo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc at nisl tincidunt, elementum lorem quis, sagittis mi. Maecenas imperdiet lacinia purus. Donec in odio a diam laoreet pharetra. Cras feugiat a nibh vel luctus. Donec dictum venenatis massa et iaculis. Proin luctus varius orci, a ultricies odio. Nulla non mattis lectus. Cras non suscipit quam, vitae tempus lectus. Pellentesque vel viverra tellus, nec scelerisque mauris. Nam purus neque, vehicula in consequat id, vulputate vel justo. Proin ornare tellus ut dignissim condimentum. Proin sit amet leo eget ligula sagittis consequat nec et ex. Quisque mi orci, porttitor eget porta vestibulum, dapibus sed turpis. Nullam vitae egestas justo. Etiam varius, augue sit amet fermentum dapibus, tellus elit feugiat ante, ac pretium libero sapien non velit. Nullam viverra lorem quis convallis feugiat. In nulla lectus, vestibulum et nisl fringilla, vulputate malesuada neque. Cras sagittis ligula lectus, vitae dignissim ex sollicitudin at. Praesent viverra efficitur enim vitae interdum. Suspendisse malesuada purus metus, consectetur fringilla tortor ultricies sit amet. Aliquam consectetur sapien quam. Integer sed orci ex. Vivamus est mi, efficitur quis leo nec, laoreet rutrum mi. Donec porta sapien est, sagittis dignissim elit luctus vitae. Praesent accumsan est a purus semper accumsan. Cras vel sapien magna. Maecenas quis mi eget ligula dapibus accumsan ut quis dolor. Proin eleifend dui eu orci porta rutrum. Nam vel congue eros, vitae vestibulum est. Sed tristique, magna a commodo posuere, dolor ex lacinia justo, sit amet semper felis nisi in nulla. Vestibulum in ultrices urna, id dictum dolor. Sed blandit euismod arcu, et volutpat nulla fringilla at. In nisi eros, convallis id posuere ac, dignissim in tortor. Morbi nisi velit, ornare ac accumsan nec, viverra ut nibh.'})
             CREATE (a3:Article {image: 'https://www.von.gov.ng/wp-content/uploads/2018/03/basketball.jpg', timestamp: '14-01-19 02:17:48', title: 'Test Title3', content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nisl at elit euismod pellentesque elementum ut sapien. Cras est nibh, rhoncus in nulla aliquam, iaculis sagittis nunc. Aenean suscipit accumsan quam, ut interdum erat ornare nec. Nullam ex orci, sollicitudin nec vehicula et, sollicitudin bibendum nisl. Donec vel ornare massa. Quisque pellentesque lacinia suscipit. Cras ornare nibh nunc, ut rutrum metus mollis efficitur. Vestibulum rutrum quam ut faucibus porta. In venenatis eros quam, nec rhoncus magna ullamcorper eu. Etiam vel sollicitudin sapien. Fusce eu massa non nisl lacinia ornare in vitae dolor. Pellentesque aliquet in odio tempor ornare. Vestibulum laoreet vehicula augue id volutpat. Quisque scelerisque massa nec purus mattis, eu porta nunc convallis. Aenean vehicula nibh at tellus dictum, ac viverra magna congue. Proin mollis nisi dolor, vel fermentum nunc iaculis sed. Sed aliquet, orci in sollicitudin tempus, tellus sem gravida eros, in euismod tellus ante a dolor. Sed scelerisque feugiat justo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc at nisl tincidunt, elementum lorem quis, sagittis mi. Maecenas imperdiet lacinia purus. Donec in odio a diam laoreet pharetra. Cras feugiat a nibh vel luctus. Donec dictum venenatis massa et iaculis. Proin luctus varius orci, a ultricies odio. Nulla non mattis lectus. Cras non suscipit quam, vitae tempus lectus. Pellentesque vel viverra tellus, nec scelerisque mauris. Nam purus neque, vehicula in consequat id, vulputate vel justo. Proin ornare tellus ut dignissim condimentum. Proin sit amet leo eget ligula sagittis consequat nec et ex. Quisque mi orci, porttitor eget porta vestibulum, dapibus sed turpis. Nullam vitae egestas justo. Etiam varius, augue sit amet fermentum dapibus, tellus elit feugiat ante, ac pretium libero sapien non velit. Nullam viverra lorem quis convallis feugiat. In nulla lectus, vestibulum et nisl fringilla, vulputate malesuada neque. Cras sagittis ligula lectus, vitae dignissim ex sollicitudin at. Praesent viverra efficitur enim vitae interdum. Suspendisse malesuada purus metus, consectetur fringilla tortor ultricies sit amet. Aliquam consectetur sapien quam. Integer sed orci ex. Vivamus est mi, efficitur quis leo nec, laoreet rutrum mi. Donec porta sapien est, sagittis dignissim elit luctus vitae. Praesent accumsan est a purus semper accumsan. Cras vel sapien magna. Maecenas quis mi eget ligula dapibus accumsan ut quis dolor. Proin eleifend dui eu orci porta rutrum. Nam vel congue eros, vitae vestibulum est. Sed tristique, magna a commodo posuere, dolor ex lacinia justo, sit amet semper felis nisi in nulla. Vestibulum in ultrices urna, id dictum dolor. Sed blandit euismod arcu, et volutpat nulla fringilla at. In nisi eros, convallis id posuere ac, dignissim in tortor. Morbi nisi velit, ornare ac accumsan nec, viverra ut nibh.'})
             CREATE (a4:Article {image: 'https://www.nbcsports.com/bayarea/sites/csnbayarea/files/styles/article_hero_image/public/2018/10/30/warriorshighs.jpg', timestamp: '14-01-19 02:17:48', title: 'Test Title4', content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nisl at elit euismod pellentesque elementum ut sapien. Cras est nibh, rhoncus in nulla aliquam, iaculis sagittis nunc. Aenean suscipit accumsan quam, ut interdum erat ornare nec. Nullam ex orci, sollicitudin nec vehicula et, sollicitudin bibendum nisl. Donec vel ornare massa. Quisque pellentesque lacinia suscipit. Cras ornare nibh nunc, ut rutrum metus mollis efficitur. Vestibulum rutrum quam ut faucibus porta. In venenatis eros quam, nec rhoncus magna ullamcorper eu. Etiam vel sollicitudin sapien. Fusce eu massa non nisl lacinia ornare in vitae dolor. Pellentesque aliquet in odio tempor ornare. Vestibulum laoreet vehicula augue id volutpat. Quisque scelerisque massa nec purus mattis, eu porta nunc convallis. Aenean vehicula nibh at tellus dictum, ac viverra magna congue. Proin mollis nisi dolor, vel fermentum nunc iaculis sed. Sed aliquet, orci in sollicitudin tempus, tellus sem gravida eros, in euismod tellus ante a dolor. Sed scelerisque feugiat justo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc at nisl tincidunt, elementum lorem quis, sagittis mi. Maecenas imperdiet lacinia purus. Donec in odio a diam laoreet pharetra. Cras feugiat a nibh vel luctus. Donec dictum venenatis massa et iaculis. Proin luctus varius orci, a ultricies odio. Nulla non mattis lectus. Cras non suscipit quam, vitae tempus lectus. Pellentesque vel viverra tellus, nec scelerisque mauris. Nam purus neque, vehicula in consequat id, vulputate vel justo. Proin ornare tellus ut dignissim condimentum. Proin sit amet leo eget ligula sagittis consequat nec et ex. Quisque mi orci, porttitor eget porta vestibulum, dapibus sed turpis. Nullam vitae egestas justo. Etiam varius, augue sit amet fermentum dapibus, tellus elit feugiat ante, ac pretium libero sapien non velit. Nullam viverra lorem quis convallis feugiat. In nulla lectus, vestibulum et nisl fringilla, vulputate malesuada neque. Cras sagittis ligula lectus, vitae dignissim ex sollicitudin at. Praesent viverra efficitur enim vitae interdum. Suspendisse malesuada purus metus, consectetur fringilla tortor ultricies sit amet. Aliquam consectetur sapien quam. Integer sed orci ex. Vivamus est mi, efficitur quis leo nec, laoreet rutrum mi. Donec porta sapien est, sagittis dignissim elit luctus vitae. Praesent accumsan est a purus semper accumsan. Cras vel sapien magna. Maecenas quis mi eget ligula dapibus accumsan ut quis dolor. Proin eleifend dui eu orci porta rutrum. Nam vel congue eros, vitae vestibulum est. Sed tristique, magna a commodo posuere, dolor ex lacinia justo, sit amet semper felis nisi in nulla. Vestibulum in ultrices urna, id dictum dolor. Sed blandit euismod arcu, et volutpat nulla fringilla at. In nisi eros, convallis id posuere ac, dignissim in tortor. Morbi nisi velit, ornare ac accumsan nec, viverra ut nibh.'})
             CREATE (a1)-[:TAGGED_TEAM]->(t1)
             CREATE (a1)-[:TAGGED_TEAM]->(t2)
             CREATE (a1)-[:TAGGED_PLAYER]->(p1)
             CREATE (a1)-[:TAGGED_PLAYER]->(p4)
             CREATE (a1)-[:TAGGED_PLAYER]->(p8)
             CREATE (a1)-[:TAGGED_PLAYER]->(p12)
             CREATE (a1)-[:TAGGED_COACH]->(c1)
             CREATE (a2)-[:TAGGED_COACH]->(c3)
             CREATE (a2)-[:TAGGED_PLAYER]->(p7)
             CREATE (a2)-[:TAGGED_PLAYER]->(p16)
             CREATE (a2)-[:TAGGED_TEAM]->(t6)
             RETURN ID(t1), ID(t2), ID(t3), ID(t4), ID(t5), ID(t6)"
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
        Redis::set('count:players', 18);
        Redis::set('count:coaches', 9);
        Redis::set('count:teams', 6);
        Redis::set('count:comments', 0);
        Redis::set('count:articles', 4);
    }
}
