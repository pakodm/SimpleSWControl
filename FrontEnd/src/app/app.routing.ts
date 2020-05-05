import { Routes } from '@angular/router';

import { DashboardComponent } from './dashboard/dashboard.component';
import { UserComponent } from './user/user.component';
import { TableComponent } from './table/table.component';
import { TypographyComponent } from './typography/typography.component';
import { IconsComponent } from './icons/icons.component';
import { MapsComponent } from './maps/maps.component';
import { NotificationsComponent } from './notifications/notifications.component';
import { UpgradeComponent } from './upgrade/upgrade.component';
import { AuthComponent, LoginComponent } from './auth/';
import { AuthGuard } from './auth-guard.service';
import { LayoutComponent } from './layout/layout.component';

export const AppRoutes: Routes = [
    {
        path: 'acceso',
        component: AuthComponent,
        children: [
          {
            path: '',
            component: LoginComponent
          },
        ]
    },
    {
        path: '',
        canActivate: [AuthGuard],
        canActivateChild: [AuthGuard],
        component: LayoutComponent,
        children: [
            {
                path: 'dashboard',
                component: DashboardComponent
            },
            {
                path: 'catalogos',
                loadChildren: './catalogos/catalogos.module#CatalogosModule'
            },
            {
                path: 'modulos',
                loadChildren: './modulos/modulos.module#ModulosModule'
            },
            {
                path: 'user',
                component: UserComponent
            },
            {
                path: 'table',
                component: TableComponent
            },
            {
                path: 'typography',
                component: TypographyComponent
            },
            {
                path: 'icons',
                component: IconsComponent
            },
            {
                path: 'maps',
                component: MapsComponent
            },
            {
                path: 'notifications',
                component: NotificationsComponent
            },
            {
                path: 'upgrade',
                component: UpgradeComponent
            }
        ]
    },
]
