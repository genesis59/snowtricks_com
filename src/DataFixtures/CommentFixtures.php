<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        /** @var User[] $users */
        $users = [
            $this->getReference('user1'),
            $this->getReference('user2'),
            $this->getReference('user3'),
            $this->getReference('user4')
        ];
        /** @var Trick[] $tricks */
        $tricks = [
            $this->getReference('trick1'),
            $this->getReference('trick2'),
            $this->getReference('trick3'),
            $this->getReference('trick4'),
            $this->getReference('trick5'),
            $this->getReference('trick6'),
            $this->getReference('trick7'),
            $this->getReference('trick8'),
            $this->getReference('trick9'),
            $this->getReference('trick10'),
            $this->getReference('trick11'),
            $this->getReference('trick12')
        ];
        $commentData = $this->getCommentData();

        for ($i = 0; $i < count($commentData); $i++) {
            $oneUser = $users[rand(0, count($users) - 1)];
            $oneTrick = $tricks[rand(0, count($tricks) - 1)];
            $comment = new Comment();
            $comment->setContent($commentData[$i]);
            $comment->setUser($oneUser);
            $comment->setTrick($oneTrick);
            $comment->setCreatedAt((new \DateTimeImmutable())->modify('-' . $i . ' day'));
            $manager->persist($comment);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TrickFixtures::class,
            UserFixtures::class
        ];
    }

    /**
     * @return string[]
     */
    private function getCommentData(): array
    {
        return [
            "Je ne vais pas mentir. Depuis qu'il est sortie, j'ai fait mes recherches dessus avant de les faire sur 
            DDG ou Google. J'ai fait mes révisions, c'était si bien expliquer, tout les termes, je pouvais les 
            comprendre, je peux maintenant vous expliquer ce qu'est un Tax Shield alors que j'ai suivie 2 heures 
            de cours dessus et que j'avais pas compris. J'ai tapé quelques fois contre les murs de ce qui étais 
            possible. Et j'ai tout adoré, tout marche si bien, mieux que le playground sur leur autre site. C'est 
            la première fois alors que j'ai essayé tout ces types de logiciels, que je suis prêt à payer pour avoir 
            accès à ces services. J'ai l'impression d'avoir un collègue qui me comprendre (sauf sur un sujet et 
            c'était relou) et qui me nourrit de savoir à une vitesse incroyable !",
            "Alors je suis en prépa, je peux te dire que cette IA est vraiment bien informé et très claire sur 
            tout ce qui est cœur résolution etc. Cependant elle n'arrive pas à résoudre non plus de gros problèmes 
            du genre des types concours. Et je peux te dire qu'en faite c'est très satisfaisant parce que ça m'a donné 
            l'impression que je travaillais pas pour rien 😅 mais en même temps ça m'a donné envie de lui apprendre 
            comment faire. Donc j'ai passé prêt d'une heure à lui poser différentes questions orientés afin qu'elle 
            réussisse le problème. Pour moi c'est une IA folle qui a énormément de possibilité d'application devant 
            elle. C'est épatant.",
            "Ce serait bien de lui demander d'essayer d'essayer de résoudre l'hypothèse de Riemann 😅",
            "Je l'utilise quand je n'arrive pas à trouver une approche pour coder certaines parties d'une app. 
            Jusque-là, je suis très satisfait.",
            "Je l'utilise pour tout c'est légendaire. Pour mes dm de python (spé nsi lol) pour des formules de 
            math / physique et les démonstrations etc... Je vais bientôt l'utiliser pour essayer de faire un oral 
            sur l'histoire d'un gars",
            "Mais c’est génial ! J’ai un exposé sur la « radio CBS » aux USA pour demain (dans 7h) et j’ai rien 
            préparé, mais OPEN IA va me sauver la vie c’est sûr 😮 Merci 😅",
            "J'adore la complexité démentielle qui se cache derrière un algorithme qui répond uniquement 'I am groot'",
            "Ce qui est flippant avec le chatGPT c'est qu'on peut lui demander une article sur un sujet totalement 
            faux, il le crée avec une très grande crédibilité alors que c'est totalement fake. Il ne dénonce 
            pas le fake...",
            "Je l’utilise souvent maintenant pour comprendre des bouts de codes 🙂",
            "C'est un truc de fou, je lui demande des conseils pour faire de la peinture de carrosserie, 
            en 10minutes il m'a fait un contre rendu de ce que j'ai péniblement lut sur des forums en 15 jours",
            "C'est incroyable! Je suis en train de tester. Je suis sur le cul.",
            "Quand elle donne des conseils de pranks c'est incroyable 😂",
            "c'est bien joli tous ca et ca peut être pratique dans pleins de domaines mais je pense que l'on 
            devrait faire attention avant de la connecter à tout notre réseau global et ou mondial, la recherche 
            c'est bien mais ca dépend comment on l'utilise ;p",
            "j'aimerai beaucoup voir une discussion de techs-philes comme vous sur les critiques faites par les 
            technocritiques/les anti-techs. Vraiment, ca m'interesserait. Je me sens entre les 2.",
            "Merci a vous c'est vraiment génial 😃",
            "il est pas capable de calculer des trucs rdm comme tu dit a un moment mais avec un pote cet aprèm 
            justement on a réussi a récup des réponses d'exo de maths expert niveau terminale (genre algorithme 
            d'euclide, PGCD, récurrence,...) c pas 100% bon mais il dit tout le déroulement du truc c flippant",
            "Jonas Degrave a publié un article de blog intitulé 'Building a virtual machine inside ChatGPT'. 
            On peut demander à ChatGPT de se comporter comme un terminal Linux, entrer de commandes, créer 
            des fichiers... la fin de l'article est incroyable, c'est Inception!",
            "J'ai beaucoup testé ChatGPT depuis sa sortie. Sa compréhension et les explications qu'il fournit 
            sont impressionnantes.",
            "Un exemple simple : demandez lui comment tracer la médiatrice d'un segment avec une règle et un 
            compas. Il donnera une suite d'instructions, mais la construction obtenue n'est pas bonne (difficile 
            d'apprendre la géométrie en se basant uniquement sur des données texte, donc ça se comprend un peu).",
            "Parfait pour me trouver des idées de cadeaux (genre un livre pour ma tante), ça marche super bien 
            quand on lui donne des associations (aime ça et ça)",
            "Est-ce qu'il a déjà été demandé à chat gpt de coder une IA ?",
            "Il y as une autre IA de OpenAI du moins une fonctionnalité qui permet de généré des texte d'un point 
            de vue humain. Il est intéressant de discuter avec elle, bon elle ce prend pour un humain mais a part 
            ça elle a une subjectivité intéressante. C'est sur Playground.",
            "Je suis pas d'accord avec le fait que c'est une réelle révolution parce que comme tu l'as dit en début 
            de vidéo ils ont juste fait une nouvelle interface graphique de GPT 3 qui pouvait déjà être fait 
            auparavant par des indépendants. Même si je trouve que l'IA est très impressionnante et m'a bien aidé 
            à faire certains devoirs....",
            "Je ne casse pas la hype : En fait j'ai l'impression que c'était des choses que faisait gpt3 très bien 
            mais wrapé dans une meilleure UX du style chatbot.",
            "C'est étrange car cette IA connait clairement le contexte de la discution que j'ai avec elle, mais 
            quand je demande combien est ce que j'ai posé de questions elle est incapable de répondre",
            "Je trouve que cette I.A est très forte pour baratiner mais jamais pour accepter son ignorance ce qui 
            est extrêmement dangereux.",
            "Je l'ai essayer pour le boulot, j'ai eu de bon conseil, après elle a quand même encore des biais... 
            Surtout que j'ai poussé loin dans le domaine de l'eau/environnement pas terrible. Mais bon sinon 
            c'est bluffant.",
            "je l'utilise pour le code, me faire des tutos ou m'aider à écrire en Anglais ",
            "je suis choqué je vient de lui demandais si il parlais breton, et OUI et c'est ultra impressionnant 
            je suis bretonnant depuis des années et ok il fait des petites fautes mais globalement c'est hyper 
            bien j'y ai verser ma petite larme",
            "Arrêtez de tous aller sur le site après avoir vu cette vidéo, il est inutilisable car il y a trop 
            de requêtes en même temps 😂😭",
            "Comment se fait-il que je n'ai jamais entendu parlé de cet outil, alors que ça fait quasiment 2 ans 
            qu'il existe (en closed beta) ? Je suis pourtant ultra interessé par l'intelligence artificielle, j'ai 
            dévoré tout le contenu possible que Youtube et Google m'a renvoyé via mes requêtes. Ils ne m'ont JAMAIS 
            mentionné cet outil, avant qu'il ne devienne viral. Je trouve ça très suspect.",
            "Pour moi le plus grand danger c'est l'affaiblissement de l'humain. A force de transférer des tâches à 
            l'IA on perd notre propre compétence. Par exemple depuis le GPS les gens ne savent plus s'orienter. 
            Avec une IA généralisée qui réfléchit à notre place il risque d'y avoir du dégât.",
            "ChatGPT me fait penser à Encarta à l'époque xD",
            "Google n'a jamais répondu aux questions. Ca a toujours été un moteur d'indexation et de recherche. 
            Son but c'est juste d'essayer de présenter les meilleurs sites qui eux répondront aux questions posés.",
            "J'ai fait un essai sur mon domaine de compétence, la thermique des bâtiments, je lui ai demandé les 
            solutions de chauffage pour une maison soumise à la réglementation environnementale 2020 et les solutions 
            restent approximative, mais il précise bien qu'il faut faire appel à un professionnel ce qui est 
            plutôt bien.",
            "ça a tellement de potentiel dans un jeu se genre d'interaction. Après faut réussir à en sortir des 
            choses niveaux gameplay basé sur la conversation.",
            "Je travaille dans la data science et sincèrement c’est miraculeux: génération de codes, de réseaux 
            de neurones ou même pour rédiger des rapports, avoir des définitions etc c’est juste incroyable",
            "Totalement folles les possibilités... ça ça dit long sur le future que l'humain dessine",
            "ChatGPT est incroyable pour ressortir et présenter des infos déjà connu (donc du passé), mais il est 
            assez limité pour proposer des inovations. Ça ressort des réponses assez scolaires à priori.",
            "mais mdrr c'est trop bien j'ai réussis a générer des structure html/css pour afficher des infos en 
            créant des classes avec au début et il ma générer le code parfaitement maintenant qu'allons nous faire 
            si des ia sont capable de coder des pages internet toute seule",
            "J'ai testé pour coder une fonction simple (une lumière qui clignote à 2Hz) sur un automate programmable 
            industriel. Je lui ai demandé des modifications pour ne pas utiliser LOOP ou WAIT et utiliser une variable 
            integer plutôt que time. L'IA fait des erreurs du type oublier de déclarer une variable, ne jamais reset 
            un timer, faire bidule_OLD := bidule; juste avant de les comparer...",
            "J'avait un projet de site a rendre pour hier soir, les 3/4 du texte je l'ai générer avec OpenAI c'est 
            vrm trop bien ça évite les copier collé wikipedia ça fait des belles phrases bien contextualisés etc... 
            J'aime trop cette IA mdr",
            "En vrai moi ca me fait un peu peur, pourtant j'adore les avancées technologiques, mais en réalité ce 
            n'est pas tant la technologie en elle meme qui m'inquiète, c'est surtout le traitement que l'on va en 
            faire. Parce qu'en tant qu'humains, il a deux choses que l'on aime pas : réfléchir trop longtemps et 
            prendre de lourdes décision. Et on va donc se mettre a utiliser GPT pour trop de décisions, et au final 
            cela va modifier son comportement (voir meme comme on le voit dans la vidéo, on peut induire un 
            comportement à l'IA) et ça risque d'etre dangereux... Il faut garder du recul la dessus, ca reste 
            un outil très intéressant, mais  à ne pas utiliser en permanence",
            "Tu combines ça a un assistant vocal et la ça va marcher",
            "après une journée le discord était déjà plein, mais très souvent ça bug parce que trop de hype, networ 
            error, si non pour nous informaticien c'est top, attention c'est limité jusqu'au 1er avril 2023",
            "Pour l'histoire du film Terminal, je le comprends d'une autre manière. On lui demande si c'est une 
            histoire vraie. Hors, de manière terre à terre, c'est faux, c'est romancé. Par contre, c'est inspiré 
            d'une histoire vraie. Pour moi, il a totalement raison. Je pense que c'est plutôt un problème 
            d'interprétation du français.",
            "Est-ce que je suis en train de voir en direct, mon futur job qui devient inutile ?",
            "Si je peux revenir sur un point que vous avez dit. Pour les questions de maths/logiques, il a faux. 
            SAUF si avant on lui précise qu'il est fort en maths, ou fort en logique, ou très intelligent... 
            Dans ce cas là il va comprendre qu'il faut poser les équations.",
            "Ultra flippant... Sur quoi ce chat se base pour être aussi omniscient ? Directement internet 
            ou d'autres data ?",
        ];
    }
}
