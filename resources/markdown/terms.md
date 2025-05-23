# Guia del Projecte

## Descripció del Projecte

Aquest projecte té com a objectiu principal la creació d'una aplicació web que permeti gestionar **vídeos**, incloent-hi la seva creació, visualització, i administració. A més, implementa funcionalitats bàsiques d'autenticació per garantir que només els usuaris autoritzats puguin interactuar amb els vídeos.

El sistema està pensat per ser **intuitiu, segur i fàcilment ampliable**, amb una arquitectura escalable que permet futures actualitzacions.

## Resum dels Sprints

### Sprint 1: Configuració inicial i funcionalitats bàsiques
1. **Configuració del projecte**:
    - Configuració inicial del framework Laravel.
    - Instal·lació de dependències necessàries i configuració del servidor local.
    - Configuració de la base de dades i migracions inicials.

2. **Creació del model Video**:
    - Definició de les columnes bàsiques per als vídeos, com ara title, description, i published_at.
    - Implementació de factories per facilitar la generació de dades de proves.

3. **Primers tests**:
    - Creació dels tests unitaris per assegurar el correcte funcionament de les funcions bàsiques del model Video.

### Sprint 2: Funcionalitats avançades i optimitzacions
1. **Visualització de vídeos**:
    - Creació de la ruta /videos/{id} per mostrar la informació detallada d'un vídeo.
    - Implementació de la pàgina amb estil personalitzat per a la visualització de vídeos.

2. **Gestió d'errors**:
    - Afegit d'una pàgina personalitzada per a errors 404 quan un vídeo no existeix.

3. **Millores als tests**:
    - Creació de tests funcionals per verificar la visualització de vídeos i el comportament davant vídeos inexistents.

Aquest document recull les accions realitzades durant el Sprint 3 del projecte de gestió de vídeos amb Laravel. S'han implementat diversos canvis i millores a l'aplicació.

### Sprint 3: Millores i Gestió de Permisos i Usuaris

1. **Corregir els errors del 2n Sprint**
    - S'han corregit els errors detectats en el 2n Sprint relacionats amb la visualització de vídeos i la gestió d'errors.

2. **Instal·lació del paquet spatie/laravel-permission**
    - S'ha instal·lat i configurat el paquet spatie/laravel-permission per gestionar els permisos d'usuaris de manera eficient.
    - S'han publicat les migracions i fitxers de configuració del paquet.

3. **Migració per afegir el camp super_admin a la taula users**
    - S'ha creat una migració per afegir el camp super_admin a la taula d'usuaris per poder identificar els usuaris amb permisos d'administrador superior.

4. **Afegir funcions al model User**
    - S'han afegit les funcions testedBy() i isSuperAdmin() al model User per gestionar els rols i permisos dels usuaris.

5. **Gestió de Permisos i Usuaris**
    - S'ha creat la funció create_default_professor per crear el professor per defecte amb permisos.
    - Es van crear les funcions create_regular_user(), create_video_manager_user(), i create_superadmin_user() per crear usuaris amb diferents rols i permisos.
    - La funció define_gates() es va implementar per definir les portes d'accés a diferents parts de l'aplicació.
    - La funció create_permissions() va ser afegida per definir els permisos relacionats amb la gestió de vídeos, com "view videos", "upload videos", "delete videos", i "manage users".

6. **Registre de polítiques d'autorització**
    - A la funció boot() de AppServiceProvider, s'han registrat les polítiques d'autorització i definides les portes d'accés necessàries.

7. **Publicació dels stubs**
    - Els stubs de Laravel s'han publicat per tal de personalitzar-los segons les necessitats del projecte.

8. **Tests**
    - S'han creat els tests necessaris per verificar el comportament dels usuaris amb diferents rols i permisos, incloent les funcions isSuperAdmin() i la gestió dels permisos en els vídeos.

### Sprint 4: Millores i Funcionalitats Addicionals

1. **Corregir els errors del 3r Sprint**
    - Corregir els errors detectats en el 3r Sprint, especialment assegurant que els usuaris amb permisos puguin accedir a la ruta /videos/manage.

2. **Crear VideosManageController**
    - Implementar les funcions testedBy, index, store, show, edit, update, delete i destroy.

3. **Crear la funció index a VideosController**
    - Implementar la funció index per mostrar tots els vídeos.

4. **Revisar vídeos creats a helpers i afegits al DatabaseSeeder**
    - Assegurar que hi ha 3 vídeos creats a helpers i afegits al DatabaseSeeder.

5. **Crear vistes per al CRUD de vídeos**
    - Crear les vistes resources/views/videos/manage/index.blade.php, resources/views/videos/manage/create.blade.php, resources/views/videos/manage/edit.blade.php, resources/views/videos/manage/delete.blade.php.

6. **Afegir taula del CRUD de vídeos a index.blade.php**
    - Implementar la taula del CRUD de vídeos a la vista index.blade.php.

7. **Afegir formulari per a vídeos a create.blade.php**
    - Implementar el formulari per afegir vídeos a create.blade.php, utilitzant l'atribut data-qa per facilitar els tests.

8. **Afegir taula del CRUD de vídeos a edit.blade.php**
    - Implementar la taula del CRUD de vídeos a edit.blade.php.

9. **Afegir confirmació d'eliminació a delete.blade.php**
    - Implementar la confirmació d'eliminació del vídeo a delete.blade.php.

10. **Crear vista de resources/views/videos/index.blade.php**
    - Implementar la vista per mostrar tots els vídeos, similar a la pàgina principal de YouTube, amb enllaços al detall del vídeo.

11. **Modificar test user_with_permissions_can_manage_videos()**
    - Assegurar que el test inclou 3 vídeos.

12. **Crear permisos de vídeos per al CRUD a helpers**
    - Crear els permisos necessaris per al CRUD de vídeos i assignar-los als usuaris corresponents.

13. **Crear funcions de test a VideoTest**
    - Implementar les funcions user_without_permissions_can_see_default_videos_page, user_with_permissions_can_see_default_videos_page, not_logged_users_can_see_default_videos_page.

14. **Crear funcions de test a VideosManageControllerTest**
    - Implementar les funcions loginAsVideoManager, loginAsSuperAdmin, loginAsRegularUser, user_with_permissions_can_see_add_videos, user_without_videos_manage_create_cannot_see_add_videos, user_with_permissions_can_store_videos, user_without_permissions_cannot_store_videos, user_with_permissions_can_destroy_videos, user_without_permissions_cannot_destroy_videos, user_with_permissions_can_see_edit_videos, user_without_permissions_cannot_see_edit_videos, user_with_permissions_can_update_videos, user_without_permissions_cannot_update_videos, user_with_permissions_can_manage_videos, regular_users_cannot_manage_videos, guest_users_cannot_manage_videos, superadmins_can_manage_videos.

15. **Crear rutes de videos/manage per al CRUD de vídeos**
    - Implementar les rutes amb el middleware corresponent i assegurar que les rutes del CRUD només apareixen quan l'usuari està logejat, mentre que la ruta d'índex és accessible tant per usuaris logejats com no logejats.

16. **Afegir navbar i footer a la plantilla resources/layouts/videosapp**
    - Implementar la navegació entre pàgines amb una barra de navegació i un peu de pàgina.

17. **Afegir a resources/markdown/terms el que s'ha fet al sprint**
    - Documentar les accions realitzades durant el Sprint 4 a resources/markdown/terms.

18. **Comprovar en Larastan tots els fitxers creats**
    - Verificar que tots els fitxers creats passen les comprovacions de Larastan.

### Sprint 5
1. Corregir els errors del 4t Sprint
   Revisa els errors que van sorgir durant el 4t Sprint.

Soluciona els problemes de codi i prova que les funcionalitats que no funcionaven es resolguin adequadament.

2. Afegir el camp user_id a la taula de vídeos
   Modifica la taula de vídeos per incloure el camp user_id que referenciarà l'usuari que va afegir el vídeo.

Modifica el model, el controlador i els helpers per gestionar aquest nou camp.

Model: Afegeix el nou camp user_id com a clau forana en la taula videos.

Controlador: Actualitza el controlador per establir el user_id quan es crea un vídeo.

3. Solucionar errors en els tests
   Si algun test anterior falla després de les modificacions, fes les correccions necessàries als tests.

4. Crear UsersManageController
   Implementa les funcions següents al UsersManageController:

testedby

index

store

edit

update

delete

destroy

5. Crear les funcions index i show a UsersController
   Afegeix les funcions index i show al UsersController per mostrar tots els usuaris i els detalls d'un usuari.

6. Crear vistes per al CRUD d'usuaris
   resources/views/users/manage/index.blade.php: Afegeix la taula per visualitzar els usuaris.

resources/views/users/manage/create.blade.php: Afegeix el formulari per crear usuaris amb l'atribut data-qa per a facilitar la identificació en els tests.

resources/views/users/manage/edit.blade.php: Afegeix la vista per editar usuaris.

resources/views/users/manage/delete.blade.php: Afegeix la confirmació per eliminar usuaris.

7. Crear la vista de resources/views/users/index.blade.php
   Aquesta vista mostrarà tots els usuaris amb la capacitat de cercar i fer clic per veure els detalls de cada usuari i els seus vídeos.

8. Crear permisos a helpers per al CRUD
   A helpers, crea permisos per al CRUD d'usuaris i assigna aquests permisos als usuaris amb rol superadmin.

9. Afegir proves a UserTest
   Crea les funcions de prova a UserTest:

user_without_permissions_can_see_default_users_page

user_with_permissions_can_see_default_users_page

not_logged_users_cannot_see_default_users_page

user_without_permissions_can_see_user_show_page

user_with_permissions_can_see_user_show_page

not_logged_users_cannot_see_user_show_page

10. Afegir proves a UsersManageControllerTest
    Crea les funcions de prova per a UsersManageController:

loginAsVideoManager

loginAsSuperAdmin

loginAsRegularUser

user_with_permissions_can_see_add_users

user_without_users_manage_create_cannot_see_add_users

user_with_permissions_can_store_users

user_without_permissions_cannot_store_users

user_with_permissions_can_destroy_users

user_without_permissions_cannot_destroy_users

user_with_permissions_can_see_edit_users

user_without_permissions_cannot_see_edit_users

user_with_permissions_can_update_users

user_without_permissions_cannot_update_users

user_with_permissions_can_manage_users

regular_users_cannot_manage_users

guest_users_cannot_manage_users

superadmins_can_manage_users

11. Crear rutes per al CRUD d'usuaris
    Afegeix les rutes per al CRUD d'usuaris a routes/web.php.

Assegura't de protegir aquestes rutes amb el middleware corresponent per garantir que només els usuaris autenticats puguin accedir a elles.

12. Afegir funcionalitat de navegació entre pàgines
    Implementa la funcionalitat per a la navegació entre pàgines en el CRUD d'usuaris, com per exemple, pàgines de llistat i detalls d'usuaris.

13. Documentació
    Afegir tota la documentació a resources/markdown/terms, descrivint els canvis realitzats al Sprint.

La documentació ha de seguir els següents punts:

Portada

Índex

Guia pas a pas de les implementacions i proves, utilitzant la metodologia TDD i AAA.

Explicació dels errors detectats per Larastan i com els has corregit.

14. Verificar amb Larastan
    Verifica els fitxers creats amb Larastan per a detectar possibles errors de tipus i altres problemes.


Sprint 6: Gestió de Sèries i Funcionalitats Avançades
Corregir errors del Sprint 5

S'han revisat i solucionat els errors trobats durant el Sprint 5.

S'han modificat els tests anteriors afectats pels canvis i s'han tornat a passar amb èxit.

Assignar vídeos a sèries

S'ha modificat el model Video per afegir la relació belongsTo amb Serie.

S'ha afegit un camp serie_id a la migració de vídeos per establir la relació.

S'han adaptat els formularis de creació i edició de vídeos per permetre seleccionar una sèrie.

Regular users poden crear vídeos

S'han afegit les funcions create, store, edit, update i destroy al VideoController per a usuaris regulars.

S'han afegit els botons corresponents a la vista videos/index.blade.php segons els permisos.

Creació de migració i model de sèries

S'ha creat una migració per a la taula series amb els camps id, title, description, image, user_name, user_photo_url i published_at.

Al model Serie s'han afegit:

Relació hasMany amb vídeos.

Funcions testedBy, getFormattedCreatedAtAttribute, getFormattedForHumansCreatedAtAttribute, getCreatedAtTimestampAttribute.

Creació de SeriesManageController

S'ha implementat el controlador SeriesManageController amb les funcions: testedBy, index, store, edit, update, delete, i destroy.

Creació de SeriesController

S'ha creat el controlador SeriesController amb les funcions index i show per mostrar les sèries i els seus vídeos.

Helpers

S'ha afegit la funció create_series() que genera tres sèries de mostra.

S'han creat els permisos necessaris per a la gestió de sèries i s'han assignat als usuaris superadmin.

Vistes CRUD per a la gestió de sèries

S'han creat les vistes:

resources/views/series/manage/index.blade.php: mostra la taula CRUD.

resources/views/series/manage/create.blade.php: formulari per crear una sèrie amb atributs data-qa.

resources/views/series/manage/edit.blade.php: formulari per editar sèries.

resources/views/series/manage/delete.blade.php: confirmació d'eliminació amb opció de desassignar vídeos.

Vista pública de sèries

S'ha creat resources/views/series/index.blade.php que mostra totes les sèries.

Es permet buscar sèries i clicar per veure els vídeos associats.

Tests

A test/Unit/SerieTest.php s'ha afegit la funció serie_have_videos() per verificar la relació.

A SeriesManageControllerTest s'han creat les funcions:

loginAsVideoManager, loginAsSuperAdmin, loginAsRegularUser

user_with_permissions_can_see_add_series

user_without_series_manage_create_cannot_see_add_series

user_with_permissions_can_store_series, user_without_permissions_cannot_store_series

user_with_permissions_can_destroy_series, user_without_permissions_cannot_destroy_series

user_with_permissions_can_see_edit_series, user_without_permissions_cannot_see_edit_series

user_with_permissions_can_update_series, user_without_permissions_cannot_update_series

user_with_permissions_can_manage_series

regular_users_cannot_manage_series, guest_users_cannot_manage_series

videomanagers_can_manage_series, superadmins_can_manage_series

Rutes

S'han creat les rutes per a series/manage amb middleware per a CRUD segons permisos.

S'han creat les rutes públiques per series/index i series/show.

Les rutes només són visibles per a usuaris loguejats on correspon.

Navegació i documentació

S'ha implementat la navegació entre pàgines.

S'ha documentat tot el treball del sprint a resources/markdown/terms.

Validació amb Larastan

S'han comprovat tots els fitxers creats amb Larastan per assegurar el compliment de bones pràctiques i absència d'errors.

### Sprint 7 - Resum de les tasques realitzades

Sprint 7 - Resum de les tasques realitzades
Correcció d'errors del Sprint 6:

S’han solucionat els errors detectats en el codi i en els tests del Sprint 6.

S’han reparat els tests que fallaven després de modificar el codi.

Funcionalitats per a usuaris regulars:

S’ha implementat la possibilitat que els usuaris regulars puguen crear sèries i afegir vídeos a aquestes.

Event VideoCreated:

S’ha creat l’event VideoCreated amb el seu constructor i la funció BroadcastOn.

L’event es dispara des del controlador quan es crea un nou vídeo.

Listener SendVideoCreatedNotification:

S’ha desenvolupat el listener SendVideoCreatedNotification.

En la funció handle(VideoCreated $event), s’envia un correu als administradors i es propaga la notificació VideoCreated amb la informació del vídeo.

EventServiceProvider:

S’ha creat el fitxer app/Providers/EventServiceProvider.php i s’hi ha registrat la notificació per la creació de vídeos.

Configuració de correu:

S’ha configurat el fitxer .env amb les credencials de Mailtrap, Mailchimp o EmailJs.

S’ha creat un compte en Mailtrap o Mailchimp per gestionar els correus.

Configuració de Pusher:

S’ha donat d’alta un compte a Pusher i s’han afegit les credencials al fitxer .env.

S’ha revisat que la configuració de config/broadcasting.php tingui Pusher com a canal per defecte.

Broadcasting i notificacions push:

S’ha inclòs la funció broadcastAs() a App/Events/VideoCreated.php i s’ha confirmat que implementa ShouldBroadcast.

S’ha configurat Laravel Echo en resources/js/bootstrap.js.

S’ha creat una vista per mostrar les notificacions push i s’han configurat els listeners per a aquests events.

Tests:

S’han creat els tests següents dins de videoNotificationsTest:

test_video_created_event_is_dispatched()

test_push_notification_is_sent_when_video_is_created()

Documentació i verificació:

S’ha afegit aquest resum dins del fitxer resources/markdown/terms.

S’han revisat tots els fitxers creats utilitzant Larastan per garantir la qualitat del codi.
