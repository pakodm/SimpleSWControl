import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { AppMaterialModule } from '../shared/material.module';
import { CatalogosRoutingModule } from './catalogos-routing.module';
import { CatalogosService } from './catalogos.service';
import { LandingComponent } from './components/landing/landing.component';
import { ProveedoresComponent } from './components/proveedores/proveedores.component';
import { EditarProveedoresComponent } from './components/proveedores/editar-proveedores/editar-proveedores.component';
import { AgregarProveedoresComponent } from './components/proveedores/agregar-proveedores/agregar-proveedores.component';
import { EliminarProveedoresComponent } from './components/proveedores/eliminar-proveedores/eliminar-proveedores.component';
import { FormProveedoresComponent } from './components/proveedores/form-proveedores/form-proveedores.component';


const PROVEEDORES_COMPONENTS = [
  ProveedoresComponent, EditarProveedoresComponent, AgregarProveedoresComponent, EliminarProveedoresComponent
];
@NgModule({
  imports: [
    CommonModule,
    CatalogosRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    AppMaterialModule
  ],
  declarations: [
    LandingComponent,
    ...PROVEEDORES_COMPONENTS,
    FormProveedoresComponent
  ],
  providers: [CatalogosService]
})
export class CatalogosModule { }
