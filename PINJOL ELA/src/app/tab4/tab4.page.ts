import { Component, OnInit } from '@angular/core';
import { PostProvider } from '../../providers/post-provider';
import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';

@Component({
  selector: 'app-tab4',
  templateUrl: './tab4.page.html',
  styleUrls: ['./tab4.page.scss'],
})
export class Tab4Page implements OnInit {

  pinjams: any = [];
  limit: number = 10;
  start: number = 0;

  constructor(
    private router: Router,
    private postPvdr: PostProvider,
    public toastController: ToastController,
  ) { }

  ngOnInit() {
  }

  ionViewWillEnter(){
    this.pinjams = [];
    this.start = 0;
    this.loadPinjam();
  }

  doRefresh(event: any) {
    setTimeout(() => {
      this.ionViewWillEnter();
      event.target.complate();
    }, 500);
  }

  loadData(event: any) {
    this.start += this.limit;
    setTimeout (() => {
      this.loadPinjam().then(() => {
        event.target.complate();
      });
    }, 500);
  }

  loadPinjam() {
    return new Promise(resolve => {
      let body = {
        aksi: 'getdata',
        limit: this.limit,
        start: this.start,
      };

      this.postPvdr.postData(body, 'action.php').subscribe(data => {
        for (let pinjam of data.result) {
          this.pinjams.push(pinjam);
        }
        resolve(true);
      });
    });
  }

}
