import { Component, OnInit } from '@angular/core';

import { CatalogosService } from '../../catalogos.service';

@Component({
  selector: 'app-landing',
  templateUrl: './landing.component.html',
  styleUrls: ['./landing.component.css']
})
export class LandingComponent implements OnInit {

  myData: any;
  menuCatalogo = [
    { Nombre: 'Proveedores', Ruta: 'proveedores' },
    { Nombre: 'Empresas', Ruta: 'empresas' },
    { Nombre: 'Medios', Ruta: 'medios' },
    { Nombre: 'Plaza', Ruta: 'plaza' },
    { Nombre: 'Clientes', Ruta: 'clientes' }
  ];

  constructor(private cs: CatalogosService) { }

  ngOnInit() {
    this.cs.getMe().subscribe((data) => {
      if (data) {
        this.myData = data;
      }
    });
  }

}
