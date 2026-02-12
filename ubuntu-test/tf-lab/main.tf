terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.0"
    }
  }
}

provider "aws" {
  region = "us-east-1"
}

data "aws_ami" "ubuntu" {
  most_recent = true
  owners      = ["099720109477"]
  
  filter {
    name   = "name"
    values = ["ubuntu/images/hvm-ssd/ubuntu-jammy-22.04-amd64-server-*"]
  }
}

resource "aws_instance" "mi-vm" {
  ami           = data.aws_ami.ubuntu.id
  instance_type = "t3.micro"
  
  tags = {
    Name = "Mi-VM-Terraform-$(date +%Y%m%d)"
  }
}

resource "aws_security_group" "permit_ssh" {
  name_prefix = "terraform-ssh"

  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["TU_IP/32"]  # Ve con: curl ifconfig.me
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

resource "aws_instance" "mi-vm" {
  # ... código anterior ...
  vpc_security_group_ids = [aws_security_group.permit_ssh.id]
}


output "public_ip" {
  value = aws_instance.mi-vm.public_ip
}
