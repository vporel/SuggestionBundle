<?php

namespace SuggestionBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;

/**
 * To be registered in the app admin dashboard
 */
class SuggestionAdminMenu
{
    public static function getMenu(): array{
        return [
            MenuItem::section("Suggestions"),
            MenuItem::linkToRoute("Suggestions", "fas fa-list", "admin.suggestions")
        ];
    }
}