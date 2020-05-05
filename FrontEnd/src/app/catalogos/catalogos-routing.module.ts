import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LandingComponent } from './components/landing/landing.component';
import { ProveedoresComponent, AgregarProveedoresComponent, EditarProveedoresComponent } from './components/proveedores/proveedores.index';

const routes: Routes = [
    { path: '', component: LandingComponent, pathMatch: 'full' },
    { path: 'proveedores', children: [
        { path: '', component: ProveedoresComponent },
        { path: 'nuevo', component: AgregarProveedoresComponent },
        { path: 'modificar/:idProveedor', component: EditarProveedoresComponent }
    ]},
    { path: '**', redirectTo: '' }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CatalogosRoutingModule { }
