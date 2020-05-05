import { Component, OnInit } from '@angular/core';
import { FormGroup, Validators, FormBuilder, FormControl } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { validateConfig } from '@angular/router/src/config';

@Component({
  selector: 'app-agregar-proveedores',
  templateUrl: './agregar-proveedores.component.html',
  styleUrls: ['./agregar-proveedores.component.css']
})
export class AgregarProveedoresComponent implements OnInit {

  proveedorForm: FormGroup;

  constructor(private fb: FormBuilder, private router: Router, private route: ActivatedRoute) {
    this.proveedorForm = this.fb.group({
      descripcion: new FormControl('', [Validators.required, Validators.minLength(1), Validators.maxLength(170)]),
      razon_social: new FormControl('', [Validators.required, Validators.minLength(1), Validators.maxLength(170)]),
      rfc: new FormControl('', []),
      calle: new FormControl('', []),
      num_exterior: new FormControl('', []),
      num_interior: new FormControl('', []),
      colonia: new FormControl('', []),
      ciudad: new FormControl('', []),
      estado: new FormControl('', []),
      cp: new FormControl('', [Validators.minLength(1), Validators.maxLength(10)]),
    });
  }

  ngOnInit() {
  }

}
