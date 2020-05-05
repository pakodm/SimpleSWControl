import { Injectable } from '@angular/core';

export interface TableStruct {
  headerRow: string[];
  dataRows: string[][];
}

@Injectable()
export class TableDataService {

  constructor() { }

}
