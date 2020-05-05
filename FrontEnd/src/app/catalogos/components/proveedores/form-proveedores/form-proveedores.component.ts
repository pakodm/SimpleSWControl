import { Component, OnInit, Input } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Component({
  selector: 'app-catalogos-form-proveedores',
  templateUrl: './form-proveedores.component.html',
  styleUrls: ['./form-proveedores.component.css']
})
export class FormProveedoresComponent implements OnInit {

  @Input() proveedoresForm: FormGroup;

  constructor() { }

  ngOnInit() {
  }

}
