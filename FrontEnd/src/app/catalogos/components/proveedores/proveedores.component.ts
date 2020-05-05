import { Component, OnInit } from '@angular/core';

import { TableStruct } from '../../../shared/interfaces/table-data.service';

@Component({
  selector: 'app-proveedores',
  templateUrl: './proveedores.component.html',
  styleUrls: ['./proveedores.component.css']
})
export class ProveedoresComponent implements OnInit {

  ListaProveedores: TableStruct;

  constructor() { }

  ngOnInit() {
    this.ListaProveedores = {
      headerRow: [ 'Descripción', 'Razón Social', 'RFC' ],
      dataRows: [
        [ 'FedEx', 'Federal Express Holdings Mexico S de RL de CV', 'FEH010101AX0' ],
        [ 'Coca Cola', 'Fomento Empresarial Mexicano SA de CV', 'FEM010101AC4' ],
        [ 'Dell', 'Computacion DELL Mexico' , 'CDM010101H01' ]
      ]
    };
  }

  deleteItem() {}

}
