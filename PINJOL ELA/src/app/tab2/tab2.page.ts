import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';
import { PostProvider } from '../../providers/post-provider';
@Component({
  selector: 'app-tab2',
  templateUrl: 'tab2.page.html',
  styleUrls: ['tab2.page.scss']
})
export class Tab2Page implements OnInit {
  nama: string = '';
  nik: string = '';
  nohp: string = '';
  email: string = '';
  usia: string = '';
  jumlah: string = '';

  constructor(
    private router: Router,
    public toastController: ToastController,
    private postPvdr: PostProvider,
  ) {

  }
  ngOnInit() {
  }
  async addRegister() {
    if (this.nama == '') {
      const toast = await this.toastController.create({
        message: 'Nama lengkap harus di isi',
        duration: 2000
      });
      toast.present();
    } else if (this.nik == '') {
      const toast = await this.toastController.create({
        message: 'Nik harus di isi',
        duration: 2000
      });
      toast.present();
    } else if (this.nohp == '') {
      const toast = await this.toastController.create({
        message: 'nohp/wa harus di isi',
        duration: 2000
      });
      toast.present();
    } else if (this.email == '') {
      const toast = await this.toastController.create({
        message: 'email harus di isi',
        duration: 2000
      });
      toast.present();
    } else if (this.usia == '') {
      const toast = await this.toastController.create({
        message: 'usia harus di isi',
        duration: 2000
      });
      toast.present();
    } else if (this.jumlah == '') {
      const toast = await this.toastController.create({
        message: 'jumlah harus di isi',
        duration: 2000
      });
      toast.present();
    } else {
      let body = {
        nama: this.nama,
        nik: this.nik,
        nohp: this.nohp,
        email: this.email,
        usia: this.usia,
        jumlah: this.jumlah,
        aksi: 'add_register'
      };
      this.postPvdr.postData(body, 'action.php').subscribe(async data => {
        var alertpesan = data.msg;
        if (data.success) {
          this.router.navigate(['/tab4']);
          const toast = await this.toastController.create({
            message: 'Selamat! Registrasi alumni sukses.',
            duration: 2000
          });
          toast.present();
        } else {
          const toast = await this.toastController.create({
            message: alertpesan,
            duration: 2000
          });
        }
      });

    }
  }
}