<?php

return [

    'blog' =>'Blog',
    'blog_settings' => 'Paramètres du blog',

    'posts' => 'Articles',
    'categories' => 'Catégories',
    'tags' => 'Mots clés',
    'comments' => 'Commentaires',


    'post_list' => 'Liste des articles',
    'category_list' => 'Liste des catégories',
    'tag_list' => 'Liste des balises',
    'comment_list' => 'Liste des commentaires',

    'create_new_post' => 'Créer un nouvel article',
    'create_new_category' => 'Créer une nouvelle catégorie',
    'create_new_tag' => 'Créer une nouvelle balise',



    'edit_post' => 'Modifier l`article',
    'edit_category' => 'Modifier la catégorie',
    'edit_tag' => 'Modifier la balise',
    'edit_comment' => 'Modifier le commentaire',

    'add_post' => 'Ajouter un article',
    'add_category' => 'Ajouter une catégorie',
    'add_new_category' => 'Ajouter une nouvelle catégorie',
    'add_tag' => 'Ajouter une balise',


    'selected_posts' => 'Articles sélectionnés',
    'selected_categories' => 'Catégories sélectionnées',
    'selected_tags' => 'Balises sélectionnées',
    'selected_comments' => 'Commentaires sélectionnés',

    'select_categories' => 'Sélectionner des catégories',
    'select_posts' => 'Sélectionner des articles',
    'select_tags' => 'Sélectionner des balises',

    'view_post' => "Voir l'article",
    'view_post_page' => 'Afficher la page de l`article',
    'view_category' => 'Afficher la catégorie',
    'view_category_page' => 'Afficher la page de la catégorie',
    'view_tag' => 'Afficher la balise',
    'view_tag_page' => 'Afficher la page des balises',


    'posts_table' => [
        'post' => 'Article',
        'id' => 'IDENTIFIANT',
        'creator' => 'Créateur par',
        'title' => 'Titre',
        'slug' => 'Slug',
        'content' => 'Contenu',
        'image' => "Image sélectionnée",
        'post_content' => 'Mettez ici le contenu de votre article',
        'published' => 'Publié',
        'active' => 'Actif',
        'visibility' => 'Visibilité',
        'public' => 'Public',
        'auth_user' => 'Utilisateur authentifié',
        'publish_on' =>'Publié le',
        'seo_title' => 'Titre SEO',
        'seo_description' => 'Description SEO',
        'seo' => 'SEO',
        'post_content_section' => 'Section contenu de l\'article',
        'comments_count' => 'Nombre de commentaires',
        'choose_post' => 'Choisir l`article',
    ],

    'categories_table' => [
        'category' => 'Catégorie',
        'id' => 'IDENTIFIANT',
        'creator' => 'Créateur par',
        'parent_category' => 'Catégorie parente',
        'choose_category' => 'Choisir une catégorie',
        'name' => 'Nom',
        'slug' => 'Slug',
        'description' => 'Description',
        'image' => 'Image de la catégorie',
        'active' => 'Actif',

        'en_name' => 'Nom en anglais',
        'ar_name' => 'Nom en arabe',
        'en_description' => 'Description en anglais',
        'ar_description' => 'Description en arabe',
    ],

    'tags_table' => [
        'tag' => 'Balise',
        'id' => 'IDENTIFIANT',
        'creator' => 'Créateur par',
        'name' => 'Nom',
        'slug' => 'Slug',
        'description' => 'Description',
        'choose_tags' => 'Choisir des balises',
        'choose_tags_or_add_new' => 'Choisir des balises ou en ajouter de nouvelles',
    ],


    'comments_table' => [
        'comment' => 'Commentaire',
        'id' => 'IDENTIFIANT',
        'creator' => 'Créateur par',
        'content' => 'Contenu',
        'author_name' => "Nom de l'auteur",
        'author_email' => "Courriel de l'auteur",
        'author_website' => "Site web de l'auteur",
    ],



    'widget_post' => [
        'one_block_and_more_side' =>'Un bloc et plus à côté',
        'side_image_blocks' => "Blocs d'images latéraux",
        'timeline_post_list' => 'Liste des articles de la chronologie',
        'full_width_blocks' => 'Blocs pleine largeur',
        'half_width_blocks' => 'Blocs demi-largeur',

        'section_title' => 'Titre de la section',
        'view_style' => 'Style d`affichage',
        'posts_order' => 'Ordre des articles',
        'posts_count' => 'Nombre d`articles',
        'display_rating' => 'Afficher la note',
        'display_category' => "Afficher la catégorie",
        'display_load_posts_button' => 'Afficher le bouton de chargement des articles',

        'order_post_types' => [
            'latest' => 'Dernier (date de publication)',
            'most_commented' => 'Le plus commenté',
            'random' => 'Aléatoire'
        ],
    ],

    'widget_newsletter' => [
        'newsletter' => 'Bulletin',
        'get_even_more' => 'Obtenez encore plus',
        'form_description' => 'Abonnez-vous à notre liste de diffusion pour recevoir les dernières mises à jour !',
        'your_email_address' => 'Votre adresse e-mail',
        'msg_spam' => 'Ne vous inquiétez pas, nous ne spammons pas.',
        'signup' => "S'inscrire",
    ],


    'widget_recent_comments' => [
        'recent_comments' => 'Commentaires récents',
        'comments_count' => 'Nombre de commentaires',
        'parent_only' => 'Afficher uniquement les commentaires de niveau un'
    ],
];