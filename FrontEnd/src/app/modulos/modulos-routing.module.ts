import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { Modulo1Component, Modulo2Component, Modulo3Component, Modulo4Component } from './components';
// import { LandingComponent } from './components/landing/landing.component';
// import { ProveedoresComponent, AgregarProveedoresComponent, EditarProveedoresComponent } from './components/proveedores/proveedores.index';

const routes: Routes = [
    /*
    { path: '', component: LandingComponent, pathMatch: 'full' },
    { path: 'proveedores', children: [
        { path: '', component: ProveedoresComponent },
        { path: 'nuevo', component: AgregarProveedoresComponent },
        { path: 'modificar/:idProveedor', component: EditarProveedoresComponent }
    ]},
    */
    { path: 'm1', component: Modulo1Component },
    { path: 'm2', component: Modulo2Component },
    { path: 'm3', component: Modulo3Component },
    { path: 'm4', component: Modulo4Component },
    { path: '**', redirectTo: 'm1' }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ModulosRoutingModule { }
