import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ModulosRoutingModule } from './modulos-routing.module';
import { ModulosService } from './modulos.service';
import { Modulo1Component } from './components/modulo1/modulo1.component';
import { Modulo2Component } from './components/modulo2/modulo2.component';
import { Modulo3Component } from './components/modulo3/modulo3.component';
import { Modulo4Component } from './components/modulo4/modulo4.component';

@NgModule({
  imports: [
    CommonModule,
    ModulosRoutingModule,
  ],
  declarations: [
    Modulo1Component, Modulo2Component, Modulo3Component, Modulo4Component
  ],
  providers: [
    ModulosService
  ]
})
export class ModulosModule { }
